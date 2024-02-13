<?php
require_once 'vendor/autoload.php';
require_once 'service/VestService.php';
require_once 'service/RubrikaService.php';
require_once 'core/init.php';
$user = new UserManager();
if (!$user->isLoggedIn())
{
    Redirect::to('index.php');
}
$vest_id = Input::get('id');
$vest = VestService::getInstance()->getVestById($vest_id);
if($vest->getIdKorisnik() != $user->data()->getIdKorisnik()) {
    Redirect::to('index.php');
}

if(Input::exists()) {
    $config = HTMLPurifier_Config::createDefault();
    $config->set('HTML.DefinitionID', 'myCustomDefinition');
    $config->set('HTML.DefinitionRev', 1);
    $config->set('HTML.Doctype', 'HTML 4.01 Transitional'); // Use a doctype that supports inline styles
    $config->set('HTML.SafeIframe', true);
    $config->set('URI.SafeIframeRegexp','%^(https://www.youtube.com/embed/)%'); // Allows YouTube iframes
    $config->set('CSS.AllowedProperties', array('position', 'padding-bottom', 'height', 'width', 'top', 'left', 'aspect-ratio'));
    $config->set('HTML.AllowedAttributes', 'iframe.src, iframe.frameborder, iframe.allowfullscreen, iframe.style, iframe.allow, div.style, div.data-oembed-url, img.src, img.alt, img.style, img.width, img.height');
    
    $def = $config->maybeGetRawHTMLDefinition();
    if ($def) {
        // Add the <figure> element
        $def->addElement(
            'figure',   // Tag name
            'Block',    // Content set
            'Optional: (figcaption, Flow) | Flow',
            'Common',   // Attribute collection
            array()     // Attributes
        );
    
        // Add custom attributes to existing elements
        $def->addAttribute('div', 'data-oembed-url', 'Text');
        
        // Allow the <iframe> element with specific attributes
        $def->addElement(
            'iframe',   // Tag name
            'Inline',   // Content set
            'Empty',    // Allowed children
            'Common',   // Attribute collection
            array(      // Attributes
                'src' => 'URI#embedded', // Allows embedding URLs, which might need further customization
                'frameborder' => 'Text',
                'allowfullscreen' => 'Bool',
                'allow' => 'Text',
                'style' => 'Text',
            )
        );
        $img = $def->addBlankElement('img');
        $img->attr['style'] = new HTMLPurifier_AttrDef_Enum(array('aspect-ratio'));
        $img->attr['width'] = 'Length';
        $img->attr['height'] = 'Length';
        $img->attr['src'] = new HTMLPurifier_AttrDef_URI();
        $style = $def->info_global_attr['style'] = new HTMLPurifier_AttrDef_CSS();
    }
    $purifier = new HTMLPurifier($config);
    $clean_html = $purifier->purify(Input::get('tekst'));
    
    $vest->setTekst($clean_html);
    VestService::getInstance()->updateVest($vest);
}

require_once 'navbar.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CKEditor Primer</title>
    <!-- CKEditor CDN -->
    <script src="ckeditor5-41.1.0/build/ckeditor.js"></script>
</head>
<body>
    <h5 class="card-title"><?php echo escape($vest->getNaslov())?></h5>
          <hr> 
          <p class="card-text">Datum: <?php echo escape($vest->getDatum())?></p>
          <p class="card-text">Rubrika: <?php echo escape(RubrikaService::getInstance()->getRubrikaById($vest->getIdRubrika())->getIme()) ?></p>
          <p class="card-text">Tagovi: <?php echo escape($vest->getTagovi()) ?></p>
          <a href="editvestnaslov.php?id=<?php echo $vest_id ?>" class="btn btn-dark">Promeni Vest</a>
          <a href="obrisivest.php?id=<?php echo $vest_id ?>" class="btn btn-danger">Obrisi Vest</a>
    <form id="editDataForm" action="" method="post">
        <textarea name="tekst" id="editor"><?php echo escape($vest->getTekst()) ?></textarea>
        <script>
            ClassicEditor
                .create(document.querySelector('#editor'), {
                            mediaEmbed: {
                        previewsInData: true
                    }
                })
                .then(editor => {
                    window.editor = editor;
                })
                .catch(error => {
                    console.error('There was a problem initializing the editor.', error);
                });
            </script>
        <div>
            <button type="submit" class="btn btn-dark" >Sacuvaj</button>
            <a href="vest.php?id=<?php echo $vest_id ?>" class="btn btn-dark">Pregledaj</a>
            <a href="posalji_uredniku.php?id=<?php echo $vest_id ?>" class="btn btn-dark">Prosledi Uredniku</a>
        </div>
    </form>
</body>
</html>

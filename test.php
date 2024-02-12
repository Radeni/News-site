<?php
require_once 'vendor/autoload.php';
require_once 'service/KomentarService.php';
require_once 'core/init.php';
var_dump($_POST);
if($_POST) {
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
    $clean_html = $purifier->purify($_POST['content']);
    $komentar = KomentarService::getInstance()->getKomentarById(2);
    $komentar->setTekst($clean_html);
    KomentarService::getInstance()->updateKomentar($komentar);
}
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
    <form id="editDataForm" action="" method="post">
        <textarea name="content" id="editor">Ovde unesite vaš tekst...</textarea>
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
        <button type="submit" class="btn btn-dark" >Edit</button>
    </form>
</body>
</html>

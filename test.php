<?php
require_once 'vendor/autoload.php';
require_once 'service/KomentarService.php';
require_once 'core/init.php';
var_dump($_POST);
if($_POST) {

    $config = HTMLPurifier_Config::createDefault();
    $config->set('HTML.DefinitionID', 'myCustomDefinition');
    $config->set('HTML.DefinitionRev', 1);
    $config->set('HTML.SafeIframe', true);
    $config->set('URI.SafeIframeRegexp','%^(https://www.youtube.com/embed/)%');
    
    $config->set('CSS.AllowedProperties', array('position', 'padding-bottom', 'height', 'width', 'top', 'left'));
    $config->set('HTML.AllowedAttributes', 'div.data-oembed-url, iframe.src, iframe.frameborder, iframe.allowfullscreen, iframe.style');
    
    $def = $config->maybeGetRawHTMLDefinition();
    
    if ($def) {
        // Allowing the <figure> and <div> elements with custom attributes
        $def->addElement('figure', 'Block', 'Flow', 'Common', array('class' => 'Text'));
        $div = $def->addBlankElement('div');
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

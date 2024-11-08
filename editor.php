<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced CKEditor with Features</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.20.2/full/ckeditor.js"></script> <!-- Full CKEditor for more features -->
    <style>
        body {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
        #editor-container, #output-container {
            width: 45%;
            margin: 20px;
        }
    </style>
</head>
<body>

<div id="editor-container">
    <h1>Content Editor</h1>
    <textarea id="editor" rows="10" cols="50" placeholder="Write your content here..."></textarea><br>
    <button id="submit">Submit</button>
    <button id="save-draft">Save Draft</button>

    <p id="char-count">Characters: 0</p>
    <p id="response"></p>
</div>

<div id="output-container">
    <h2>Live Preview</h2>
    <div id="live-preview" style="border: 1px solid #ccc; padding: 10px;"></div>
    
    <h2>Submitted Content</h2>
    <div id="content-area">
        <!-- Placeholder for fetching submitted content -->
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize CKEditor
    CKEDITOR.replace('editor');

    // Load draft if available
    var draftContent = localStorage.getItem('draftContent');
    if (draftContent) {
        CKEDITOR.instances.editor.setData(draftContent);
    }

    // Character count
    CKEDITOR.instances.editor.on('contentDom', function() {
        CKEDITOR.instances.editor.document.on('keyup', function() {
            var content = CKEDITOR.instances.editor.getData();
            $('#char-count').text('Characters: ' + content.length);
        });
    });

    // Live Preview
    CKEDITOR.instances.editor.on('change', function() {
        var content = CKEDITOR.instances.editor.getData();
        $('#live-preview').html(content);
    });

    // Submit content
    $('#submit').click(function() {
        var content = CKEDITOR.instances.editor.getData();

        $.ajax({
            url: 'submit_content.php',
            type: 'POST',
            data: {content: content},
            success: function(response) {
                $('#response').html(response);
                CKEDITOR.instances.editor.setData(''); // Clear editor after submission
                localStorage.removeItem('draftContent'); // Clear the draft after submission
                $('#content-area').load('fetch_data.php'); // Load the latest content
            },
            error: function() {
                $('#response').html('Error occurred while submitting.');
            }
        });
    });

    // Save draft in localStorage
    $('#save-draft').click(function() {
        var content = CKEDITOR.instances.editor.getData();
        localStorage.setItem('draftContent', content);
        alert('Draft saved!');
    });

    // Auto-save draft every 10 seconds
    setInterval(function() {
        var content = CKEDITOR.instances.editor.getData();
        localStorage.setItem('autoSaveContent', content);
        console.log('Auto-saved content');
    }, 10000);
});
</script>

</body>
</html>

import "tinymce/tinymce";
import "tinymce/skins/ui/oxide/skin.min.css";
import "tinymce/skins/content/default/content.min.css";
import 'tinymce/icons/default/icons.min.js';
import 'tinymce/themes/silver/theme.min.js';
import 'tinymce/models/dom/model.min.js';
import "tinymce/plugins/advlist";
import "tinymce/plugins/lists";
import "tinymce/plugins/image";

window.addEventListener("DOMContentLoaded", () => {
    tinymce.init({
        selector: "textarea",
        promotion: false,
        plugins: "lists advlist , image",
        toolbar: "numlist bullist image",
        height: 300,
        images_upload_url: "/upload-image",
        file_picker_types: "image",
        images_upload_base_path: "/show-mce/",
        images_upload_credentials: true,

        /* TinyMCE configuration options */
        skin: false,
        content_css: false,
    });
});

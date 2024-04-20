// Get the checkbox element and the section element
// var checkbox = document.getElementById("isEmailTemplate");
// var section = document.getElementById("sectionToToggle");

// // Add an event listener to the checkbox for the "change" event
// checkbox.addEventListener("change", function() {
//     // Check if the checkbox is checked
//     if (checkbox.checked) {
//         // If checked, show the section
//         section.style.display = "block";
//     } else {
//         // If not checked, hide the section
//         section.style.display = "none";
//     }
// });

var editorElement = document.getElementById('opinify_email_template_editor');
var editorContent = editorElement ? editorElement.value : '';
console.log(editorContent);

// const captchaElement = document.getElementById('is_captcha');
// const captchaKeyElement = document.querySelector('.opinify_captcha_key_setting');

// captchaElement.addEventListener('change', function() {
//     // Toggle the display of section1 based on the checkbox state
//     captchaKeyElement.style.display = this.checked ? 'block' : 'none';
// });

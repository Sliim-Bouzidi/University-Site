<?php
// session_start();
// if (isset($_SESSION['success'])) {
//   echo '<div class="success-message">' . $_SESSION['success'] . '</div>';
//   unset($_SESSION['success']);
// }
?>
<!DOCTYPE html>
<html lang="en">
<script>
// Find the success message element
var successMessage = document.querySelector('.success-message');

// If the success message element exists, add a timeout function to hide it after 3 seconds
if (successMessage) {
  setTimeout(function() {
    successMessage.style.display = 'none';
  }, 1500);
}
</script>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="course_style.css">
  <style>
  @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
  @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap');
  </style>
</head>

<body>

  <div class="container">
    <form method="post" action="upload_course.php" enctype="multipart/form-data">
      <h2>Upload Your Course</h2>

      <div class="form-group">
        <input type="text" id="course_title" name="course_title" required>
        <label for="course_title">Course Title</label>
      </div>
      <div class="form-group">
        <input type="text" name="course_Licence" id="course_Licence" required>
        <label for="course_Licence">Licence</label>
      </div>
      <div class="form-group">
        <input type="text" name="price" id="price" required>
        <label for="price">Price</label>
      </div>
      <div class="form-group">
        <textarea id="course_description" name="course_description" required></textarea>
        <label for="course_description">Course Description</label>
      </div>

      <br>
      <div>
        Image Course:
        <input type="file" name="image" />
      </div>
      <br>

      <div class="form-group">

        <div class="container-2">
          <div class="card">
            <h3>Upload Files</h3>
            <div class="drop_box">
              <header>
                <h4>Select File here</h4>
              </header>
              <p>Files Supported: PDF, TEXT, DOC , DOCX</p>
              <input type="file" name="file"
                accept=".jpg,.jpeg,.png,.gif,.svg,.bmp,.webp,.ico,.mp3,.wav,.aac,.mp4,.avi,.mkv,.mov,.wmv,.flv,.pdf,.txt,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                id="fileID" style="display:none;" required>
              <button class="btn">Choose File</button>
            </div>
          </div>
        </div>

      </div>
      <button type="submit">Submit</button>
    </form>
  </div>

  <script>
  const dropArea = document.querySelector(".drop_box");
  const button = dropArea.querySelector("button");
  const input = dropArea.querySelector("input");

  button.onclick = () => {
    input.click();
  };

  input.addEventListener("change", function(e) {
    // Remove header, p, and button elements
    dropArea.querySelectorAll("header, p, button").forEach(element => {
      element.remove();
    });

    const fileName = e.target.files[0].name;
    const filedata = `
    <div class="form">
      <h4>${fileName}</h4>
    </div>`;
    const newElement = document.createElement('div');
    newElement.innerHTML = filedata;
    dropArea.appendChild(newElement);
  });
  </script>


</body>

</html>
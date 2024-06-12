<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
  <!-- Font Awseome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css"
    integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />

  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
  <!-- csss -->
  <style>
  .join-class-container {
    color: #6f8ba4;
    margin: auto;
    margin-top: 20vh;
    max-width: 35rem;
    width: 100%;
    background-color: #fff;
    border: 0.093rem solid #dadce0;
    border-radius: 0.5rem;
    overflow: hidden;
    padding: 1.8rem 0.8rem;
    line-height: 0.5rem;
    /* height: 100%; */
  }

  .join-class-container p {
    margin-left: 0.5rem;
  }

  /*Nos  Formations */
  </style>
</head>

<body>

  <!-- main section -->
  <main class="container">
    <form class="join-class-container" action="courses_view2.php" method="POST">
      <h4>Enrollment Key</h4>
      <p>Ask your teacher for the class code, then enter it here.</p>
      <div class="form-floating mt-4 mb-4">
        <input type="text" class="form-control" name="enrollment_key" id=" class-code" placeholder="enrollment_key"
          value="" required>
        <label for="class-code">Enrollment Key</label>
      </div>
      <h4>Your Class</h4>
      <div class="form-floating mt-4 mb-4">
        <input type="text" class="form-control" name="classLevel" id="class-code" placeholder="Class code" value=""
          required>
        <label for="class-code">Class</label>
      </div>
      <h5>To sign in with a class code </h5>
      <ul class="p-3 lh-base">
        <li class="ms-2 mb-2">Use an authorised account</li>
        <li class="ms-2">Use a class code with 5-7 letters or numbers, and no
          spaces or symbols</li>
      </ul>
      <button class="w-100 btn btn-lg btn-primary" type="submit">
        Join
      </button>
    </form>
  </main>
</body>

</html>
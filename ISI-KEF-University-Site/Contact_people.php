<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">


  <title>Contacts Grid Cards - Bootdey.com</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script type="text/javascript"
    src="https://gc.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=Jev1Qv7GS7dnI9oZ2TwZRoTpkTVa6MBM_vLqRT03Pm5qGy7ZFQPtJymjpyiG2Xtfxg0ES7Tb0O9YDYbG9SNLoW512MPVz_9v42k0NZp229M"
    charset="UTF-8"></script>
  <link rel="stylesheet" href="contact_people.css">
</head>

<body>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css"
    integrity="sha512-pVCM5+SN2+qwj36KonHToF2p1oIvoU3bsqxphdOIWMYmgr4ZqD3t5DjKvvetKhXGc/ZG5REYTT6ltKfExEei/Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css"
    integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="mb-3">
          <h5 class="card-title">Contact List <span class="text-muted fw-normal ms-2">(834)</span></h5>
        </div>
      </div>
      <div class="col-md-6">
        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
          <div>
            <ul class="nav nav-pills">
              <li class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="tooltip" data-bs-placement="top" title="List"><i
                    class="bx bx-list-ul"></i></a>
              </li>
              <li class="nav-item">
                <a aria-current="page" href="#" class="router-link-active router-link-exact-active nav-link active"
                  data-bs-toggle="tooltip" data-bs-placement="top" title="Grid"><i class="bx bx-grid-alt"></i></a>
              </li>
            </ul>
          </div>
          <div>
            <a href="#" data-bs-toggle="modal" data-bs-target=".add-new" class="btn btn-primary"><i
                class="bx bx-plus me-1"></i> Add New</a>
          </div>
          <div class="dropdown">
            <a class="btn btn-link text-muted py-1 font-size-16 shadow-none dropdown-toggle" href="#" role="button"
              data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <?php
      // Connect to the database
      $conn = mysqli_connect('localhost', 'root', '', 'isikef');

      // Check connection
      if (!$conn) {
          die('Connection failed: ' . mysqli_connect_error());
      }

      // Select data from the etudiant and enseignant tables
      $sql = "(SELECT Nom, Prenom, Email, Classe, Image FROM etudiant)
          UNION
          (SELECT Nom, Prenom, Email, Grade, Image FROM enseignant)";
      $result = mysqli_query($conn, $sql);

      // Generate HTML code for each student or teacher
      while ($row = mysqli_fetch_assoc($result)) {
          $nom = $row['Nom'];
          $prenom = $row['Prenom'];
          $email = $row['Email'];
          $classe_ou_grade = isset($row['Classe']) ? $row['Classe'] : $row['Grade'];
          $image = base64_encode($row['Image']); // encode the binary data using base64
      
          echo '
  <div class="col-xl-3 col-sm-6">
    <div class="card">
      <div class="card-body">
        <div class="dropdown float-end">
          <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown"
            aria-haspopup="true"><i class="bx bx-dots-horizontal-rounded"></i></a>
          <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Edit</a><a
              class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Remove</a></div>
        </div>
        <div class="d-flex align-items-center">
          <div><img src="data:image/jpeg;base64,' . $image . '" alt=""
              class="avatar-md rounded-circle img-thumbnail" /></div>
          <div class="flex-1 ms-3">
            <h5 class="font-size-16 mb-1"><a href="#" class="text-dark">' . $prenom . ' ' . $nom . '</a></h5>
            <span class="badge badge-soft-success mb-0">' . $classe_ou_grade . '</span>
          </div>
        </div>
        <div class="mt-3 pt-1">
          <p class="text-muted mb-0"><i class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i> ' . $email . '</p>
        </div>
        <div class="d-flex gap-2 pt-4">
          <button type="button" class="btn btn-soft-primary btn-sm w-50"><i class="bx bx-user me-1"></i>
            Profile</button>
          <button type="button" class="btn btn-primary btn-sm w-50"><i class="bx bx-message-square-dots me-1"></i>
            Contact</button>
        </div>
      </div>
    </div>
  </div>';
      }

      // Close the database connection
      mysqli_close($conn);
      ?>
    </div>

    <div class="row g-0 align-items-center pb-4">
      <div class="col-sm-6">
        <div>
          <p class="mb-sm-0">Showing 1 to 10 of 57 entries</p>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="float-sm-end">
          <ul class="pagination mb-sm-0">
            <li class="page-item disabled">
              <a href="#" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
            </li>
            <li class="page-item active"><a href="#" class="page-link">1</a></li>
            <li class="page-item"><a href="#" class="page-link">2</a></li>
            <li class="page-item"><a href="#" class="page-link">3</a></li>
            <li class="page-item"><a href="#" class="page-link">4</a></li>
            <li class="page-item"><a href="#" class="page-link">5</a></li>
            <li class="page-item">
              <a href="#" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript">

  </script>
</body>

</html>
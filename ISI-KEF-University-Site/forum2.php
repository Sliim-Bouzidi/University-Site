<?php
session_start();

// Connect to database
$host = "localhost";
$dbname = "isikef";
$username = "root";
$password = "";
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";



try {
  $pdo = new PDO($dsn, $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}



// Fetch topics from database
$stmt = $pdo->prepare("SELECT id, CIN, title, description, user, type, image, created_at FROM topics ORDER BY created_at DESC");
$stmt->execute();
$topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if topic_id is set
if (isset($_GET['topic_id'])) {
  $topic_id = $_GET['topic_id'];
} else {
  $topic_id = ''; // set default value
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Discussion Forum</title>
  <style>
  @import url('https://fonts.googleapis.com/css2?family=Inter&family=Poppins:wght@500;600&display=swap');

  .container {
    margin: 20px auto;
    max-width: 1100px;
    padding: 30px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  }

  table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }

  th,
  td {
    text-align: left;
    padding: 8px;
    color: #828894;
    font-size: 16px;
    font-weight: 400;
    font-style: normal;
    font-family: 'Inter', 'Poppins', sans-serif;
    border-bottom: 1px solid #E4E4E4;
  }

  th {
    background-color: #F9FAFB;
    color: #000;
    font-weight: bold;
    padding: 8px 15px;
  }

  tr:nth-child(even) {
    background-color: #F9FAFB;
  }

  .reply1 a {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4F46E5;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    font-size: 16px;
    font-weight: 400;
    font-style: normal;
    font-family: 'Inter', 'Poppins', sans-serif;
    text-align: center;
  }

  .reply1 a:hover {
    background-color: #3b329f;
  }

  /*.profile-image {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
  }*/

  .profile-image {
    position: relative;
    width: 55px;
    height: 55px;
    border-radius: 50%;
    overflow: hidden;
    cursor: pointer;
    margin-right: 10px;

  }

  .profile-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;

  }

  .user {
    font-weight: bold;
    color: #000;
    font-size: 18px;
    display: flex;
    align-items: center;
  }

  td:first-child {
    display: flex;
    align-items: center;
    color: #000;
  }

  td:first-child>span {
    margin-left: 10px;
  }

  td:nth-child(n+3) {
    text-align: center;
  }

  td:last-child {
    text-align: right;
    border-radius: 0 10px 10px 0;
  }

  .table-container {
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    overflow: hidden;
  }

  .topic-actions {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .topic-actions a {
    margin-right: 10px;
    text-decoration: none;
    font-weight: bold;
  }

  .topic-actions a.delete {
    color: #d32f2f;
  }

  .topic-actions a.edit {
    color: #1e88e5;
  }

  .topic-actions a.reply {
    color: #388e3c;
  }

  .topic-actions a:hover {
    text-decoration: underline;
  }
  </style>
</head>

<body>
  <div class="container">
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>User</th>
            <th>Title</th>
            <th>Created At</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($topics as $topic): ?>
            <tr>
              <td>
                <?php $imageData = $topic['image'];
                $imageBase64 = base64_encode($imageData);
                $imageSrc = 'data:image/jpeg;base64,' . $imageBase64; ?>
                <div class="profile-image">
                  <img src="<?php echo $imageSrc ?>" alt="User Profile Image">
                </div>
                <?php echo $topic['user']; ?>
              </td>
              <td><?php echo $topic['title']; ?></td>
              <td><?php echo $topic['created_at']; ?></td>
              <td>
                <div class="topic-actions">
                  <?php /*if (isset($_SESSION['cin']) && $_SESSION['cin'] == $topic['CIN']): */?>
                  <a class="delete" id="delete-topic-btn" href="delete_topic.php?topic_id=<?php echo $topic['id']; ?>"
                    onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                  <a class="edit" href="edit_topic.php?topic_id=<?php echo $topic['id']; ?>">Edit</a>
                  <?php /*endif;*/?>
                  <a class="reply" href="forum3.php?topic_id=<?php echo $topic['id']; ?>">Reply</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
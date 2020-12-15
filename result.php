<?php
include('dbconnect.php');
$title = "Search Result";
include('header.html');
function DisplayErrors()
{
    global $errors;
    echo "The following error/s encountered:";
    echo "<ol>";
    foreach ($errors as $k => $v) {
        echo "<li>$v</li>";
    }
    echo "</ol>";
    echo "<p><a href=javascript:history.back();>click here to correct the errors</a></p>";
}
$errors = array();
$BookLng = ['A' => 'Arabic', 'E' => 'English'];
echo "<h2>Search Result for books</h2>";
if (
    empty($_POST['BookTitle']) && empty($_POST['BookID']) && empty($_POST['BookCopies']) && empty($_POST['BookDate']) &&
    !isset($_POST['BookLng']) && $_POST['BookSubject'] == 'none'
) {
    $errors[] = "Please type data in at least one filed.";
} else {
    if (!empty($_POST['BookDate'])) {
        list($y, $m, $d) = explode("-", $_POST['BookDate']);
        $bd = mktime(0, 0, 0, $m, $d, $y);
        $today = time();
        if (!checkdate($m, $d, $y) || $bd > $today) {
            $errors[] = "Enter Correct Publishing Date.";
        }
    }
}
if (count($errors) == 0) {
    echo "<h4><u>Your searching values are</u>:</h4>";
    if (!empty($_POST['BookTitle'])) echo "<b>Book Title:</b> {$_POST['BookTitle']} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    if (!empty($_POST['BookID'])) echo "<b>Book ID:</b> {$_POST['BookID']} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    if (!empty($_POST['BookCopies'])) echo "<b>Book Copies:</b> {$_POST['BookCopies']} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    if (!empty($_POST['BookDate'])) echo "<b>Publishing Date: </b>{$_POST['BookDate']} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    if (isset($_POST['BookLng'])) {
        echo "<b>Language:</b> {$BookLng[$_POST['BookLng']]} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    }
    if ($_POST['BookSubject'] != 'none') {
        $SubjectQuery = "SELECT BookSubjectDesc FROM booksubjects WHERE BookSubjectId = '{$_POST['BookSubject']}' ";
        $sql = mysqli_query($conn, $SubjectQuery) or die("There is an error in query:$SubjectQuery" . mysqli_error($conn));
        list($dpn) = mysqli_fetch_row($sql);
        echo "<b>Subject:</b> $dpn ";
    }


    $q = "SELECT * FROM books WHERE bookId > 0";
    if (!empty($_POST['BookID'])) {
        $q .= " and bookId = '{$_POST['BookID']}'";
    }
    if (!empty($_POST['BookTitle'])) {
        $q .= " and bookTitle like '{$_POST['BookTitle']}%'";
    }
    if (!empty($_POST['BookCopies'])) {
        $q .= " and bookNoOfCopies = '{$_POST['BookCopies']}'";
    }
    if (!empty($_POST['BookDate'])) {
        $q .= " and bookPubDate = '{$_POST['BookDate']}'";
    }
    if ($_POST['BookSubject'] != 'none') {
        $q .= " and bookSubjectId ='{$_POST['BookSubject']}'";
    }
    if (isset($_POST['BookLng'])) {
        $q .= " and bookLanguageCode = '{$_POST['BookLng']}'";
    }
    $row = mysqli_query($conn, $q) or die("Error in the query $q " . mysqli_error($conn));
    $n = mysqli_num_rows($row);
    if ($n == 0) {
        echo "<h4 style='color:red; text-align:center;'>No data matching your search criteria......</h4>";
    } else {
        echo "<h4 style='color:green; text-align:center;'>There are $n Books matching your searching </h4>";
        echo "<table class='result'>
            <thead>
            <tr>
            <th>Booked ID</th>
            <th>Book title</th>
            <th>#Copies</th>
            <th>Book Language</th>
            <th>Price</th>
            <th>Subject Description</th>
            <th>Publishing Date</th>
            </tr>
            </thead><tbody>";
        while ($key = mysqli_fetch_assoc($row)) {
            $id = $key["bookId"];
            $title = "<a href='book.php?bookId={$key["bookId"]}'>{$key["bookTitle"]}</a>
            <form action='editBookForm.php' method='post'><input type='hidden' name='id' value='{$key["bookId"]}'><input type='submit' value='Edit'></form>";
            $copies = $key["bookNoOfCopies"];
            $lang = $BookLng[$key["bookLanguageCode"]];
            $price = number_format($key["bookPrice"], 3);

            $SQuery = "SELECT BookSubjectDesc FROM booksubjects WHERE BookSubjectId = '{$key["bookSubjectId"]}' ";
            $ss = mysqli_query($conn, $SQuery) or die("There is an error in query:$SQuery" . mysqli_error($conn));
            list($sub) = mysqli_fetch_row($ss);

            $ago = (date('Y') - date('Y', strtotime($key["bookPubDate"])));
            //$pdate = date('d M(m) Y') . "<br> $ago years ago";
            $pdate = date('d M(m) Y',strtotime($key["bookPubDate"])) . "<br> $ago years ago";

            echo "<tr>";
            echo "<td>$id</td>";
            echo "<td>$title</td>";
            echo "<td>$copies</td>";
            echo "<td>$lang</td>";
            echo "<td>$price</td>";
            echo "<td>$sub</td>";
            echo "<td>$pdate</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    }
} else {
    DisplayErrors();
}
include('footer.html');
?>

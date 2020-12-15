<?php
include('dbconnect.php');
$title = "Error";
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
echo "<h2>Editing book data</h2>";

if (
    empty($_POST['BookTitle']) or empty($_POST['BookPrice']) or empty($_POST['BookCopies']) or empty($_POST['BookDate']) or
    !isset($_POST['BookLng']) or empty($_POST['BookSubject'])
) {
    $errors[] = "All fields are required. You should not leave any field blank.";
} else {
    if (!empty($_POST['BookTitle'])) {
        //if (!preg_match("/^([A-Za-z0-9\s\,\-\.\/]){1,50}$/", $_POST['BookTitle'])) {
        if (!preg_match("/^([A-Za-z0-9\,\-\s]){1,50}$/", $_POST['BookTitle'])) {
            $errors[] = "Please correct book title.";
        }
    }
    if (!empty($_POST['BookPrice'])) {
        if (!preg_match("/^([0-9]){1,3}(\.[0-9]{0,3})?$/", $_POST['BookPrice'])) {
            $errors[] = "Book price must be maximum of 3 integers and 3 decimal places.";
        }
    }
    if (!empty($_POST['BookCopies'])) {
        if (!preg_match("/^[0-9]{1,2}$/", $_POST['BookCopies']) or $_POST['BookCopies'] == 0) {
            $errors[] = "Number of copies must be maximum 2 digits and not equal to zero.";
        }
    }
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
    $cleanTitle = ucfirst(strtolower(trim($_POST['BookTitle'])));
    $q = "update books set BookTitle='$cleanTitle',bookNoOfCopies='{$_POST['BookCopies']}',";
    $q .= " bookLanguageCode='{$_POST['BookLng']}',bookPrice='{$_POST['BookPrice']}',";
    $q .= " bookSubjectId='{$_POST['BookSubject']}',bookPubDate='{$_POST['BookDate']}'";
    $q .= " where bookId='{$_POST['BookID']}'";
    $r = mysqli_query($conn, $q) or die("Error $q" . mysqli_error($conn));
    header("location:index.php");
} else {
    DisplayErrors();
}


include('footer.html');
?>
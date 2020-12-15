<?php
include('dbconnect.php');
$title = "Editing data";
include('header.html');

$q = "select * from books where bookId='{$_POST['id']}'";
$r = mysqli_query($conn, $q) or die("Error in query $q" . mysqli_error($conn));
$book = mysqli_fetch_assoc($r);
$BookLng = ['A' => 'Arabic', 'E' => 'English'];
?>
<h2>Editing book data</h2>
<form method="POST" action="saveChanges.php">
    <table style="width: 100%;">
        <tr>
            <td>Book ID</td>
            <td><?php echo $_POST['id']; ?>
                <input type="hidden" name="BookID" value="<?php echo $_POST['id']; ?>"></td>
            <td># of Copies</td>
            <td><input type="text" name="BookCopies" value="<?php echo $book['bookNoOfCopies']; ?>" size="5"></td>

        </tr>
        <tr>
            <td>Title</td>
            <td><input type="text" name="BookTitle" value="<?php echo $book['bookTitle']; ?>"></td>
            <td>Price</td>
            <td><input type="text" name="BookPrice" size="5" value="<?php echo $book['bookPrice']; ?>"> O.R</td>
        </tr>
        <tr>
            <td>Subject</td>
            <td>
                <select name="BookSubject">
                    <?php
                    $query = "select BookSubjectId,BookSubjectDesc from booksubjects";
                    $result = mysqli_query($conn, $query) or die("Error in Query $query" . mysqli_error($conn));
                    while (list($bID, $bDESC) = mysqli_fetch_row($result)) {
                        echo "<option value='$bID' ";
                        if ($bID == $book['bookSubjectId']) echo " selected";
                        echo ">$bDESC - $bID </option>";
                        echo "\n";
                    }
                    ?>
                </select>
            </td>
            <td>Book language</td>
            <td>
                <?php
                foreach ($BookLng as $k => $v) {
                    echo "<input type='radio' name='BookLng' value='$k'";
                    if ($k == $book['bookLanguageCode']) echo " checked";
                    echo " > $v \n";
                } ?>
            </td>
        </tr>
        <tr>
            <td>Publishing Date</td>
            <td><input type="date" name="BookDate" value="<?php echo $book['bookPubDate']; ?>"></td>
        </tr>
    </table>
    <br>
    <center><button type="submit">Save Book Data</button></center>
</form>
<?php include('footer.html'); ?>
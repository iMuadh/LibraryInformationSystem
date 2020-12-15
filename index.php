<?php
$title = "Home";
include('header.html');
?>
<h2>Searching for Books</h2>
<p style="color:red; text-align:center;"><b>Please input or select at least one field</b></p>
<form method="POST" action="result.php">
    <table style="width: 100%;">
        <tr>
            <td>Title</td>
            <td><input type="text" name="BookTitle"></td>
            <td>Book ID</td>
            <td><input type="text" name="BookID"></td>
        </tr>
        <tr>
            <td># of Copies</td>
            <td><input type="text" name="BookCopies"></td>
            <td>Book language</td>
            <td><input type="radio" name="BookLng" value="A">Arabic
                <input type="radio" name="BookLng" value="E">English</td>
        </tr>
        <tr>
            <td>Publishing Date</td>
            <td><input type="date" name="BookDate"></td>
            <td>Subject</td>
            <td><select name="BookSubject" id="">
                    <option value="none">Select from the list</option>
                    <option value="ARB">Arabic Books - ARB</option>
                    <option value="BUS">Business Studies - BUS</option>
                    <option value="ENG">Engineering - ENG</option>
                    <option value="LNG">English Language - LNG</option>
                    <option value="IT">Information Technology - IT</option>
                    <option value="MED">Medicine - MED</option>
                    <option value="REL">Islamic - REL</option>
                </select></td>
        </tr>
    </table>
    <br>
    <center><button type="submit">Dispaly Search Result</button></center>
</form>
<?php
include('footer.html');
?>
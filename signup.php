<?php include("common1.html"); ?>
<!-- This is the signup form for singles -->
<div>
    <form action="signup-submit.php" method="POST" enctype="multipart/form-data" class="forms">
    <fieldset>
        <legend>New User Signup:</legend>

        <strong class="column">Name:</strong>
        <input type="text" name="name" size="33" maxlength="32"><br><br>

        <strong class="column">Gender:</strong>
        
        
        <input type="radio" name="gender" value="M">Male
        <input type="radio" name="gender" value="F" checked>Female<br><br>
        

        <strong class="column">Age:</strong>
        <input type="text" name="age" size="6" maxlength="2"><br><br>

        <strong class="column">Personality Type:</strong>
        <input type="text" name="personality-type" size="6" maxlength="4">
        <a href="http://www.humanmetrics.com/cgi-win/JTypes2.asp" target="_blank"> (Don't know your type?)</a><br><br>

        <strong class="column">Favorite OS:</strong>
        <select name="favorite_os">
        <option value="Mac OS X" > Mac OS X</option>
            <option value="Linux"> Linux</option>
            <option value="Windows" selected> Windows</option>
        </select><br><br>

        <strong class="column">Seeking age:</strong>
        <input type="text" name="min-seeking-age" size="6" maxlength="2" placeholder="min"> to
        <input type="text" name="max-seeking-age" size="6" maxlength="2" placeholder="max"><br><br>

        <strong class="column">Seek Gender(s):</strong>
        <input type="checkbox" name="seeking[]" checked="checked" value="M" /> Male 
        <input type="checkbox" name="seeking[]" value="F" /> Female
        
         <br><br>

        <strong class="column">Photo(Optional): </strong>
        <input type="file" name="fileToUpload" id="fileToUpload"/>
        <input type="submit" value="Sign up" name="submit" />
    </fieldset>
    </form>
</div>

<?php include("common2.html"); ?>
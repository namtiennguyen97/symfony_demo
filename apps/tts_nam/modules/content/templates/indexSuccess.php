<!-- apps/frontend/templates/layout.php -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Jobeet - Your best job board</title>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_javascripts(); ?>
    <?php include_stylesheets() ;?>
</head>
<body>
<p class="title">nam nguyen</p>
<div id="container">

    <form method="post" id="mainForm" action="<?php echo url_for('send-post') ?>">
        Add title <br>
        <input type="text" name="title"/>
        <button type="submit">Submit</button>
    </form>
</div>
<div>
    <table>
        <tr>
            <th>Name</th>
            <th>Action</th>
        </tr>
        <tbody>

        </tbody>
    </table>
</div>
</body>
</html>

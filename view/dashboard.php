<!DOCTYPE html>
<html lang="zxx">

<head>
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<div class="loader-section">
     <span class="loader"></span>
</div>
<?php
    include 'whiteList.php';
?>

<script>

    document.onload = pageLoaded();

    function pageLoaded() {
        let loaderSection = document.querySelector('.loader-section');
        loaderSection.classList.add('loaded');
    }

    function closeModal(modal) {
        $('#' + modal).modal('hide');
    }

</script>

</html>

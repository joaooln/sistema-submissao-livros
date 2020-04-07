<?php
if (!isset($seg)) {
    exit;
}
?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="<?php echo pg; ?>/assets/js/dashboard.js" ></script>
<script defer src="<?php echo pg; ?>/assets/js/1351.js"></script>
<script defer src="<?php echo pg; ?>/assets/js/bs-custom-file-input.min.js"></script>
<script defer src="<?php echo pg; ?>/assets/js/jquery.mask.min.js"></script>
<script>
    bsCustomFileInput.init();
    var btn = document.getElementById('btnResetForm');
    var form = document.querySelector('form');
    btn.addEventListener('click', function () {
        form.reset();
    });
</script>
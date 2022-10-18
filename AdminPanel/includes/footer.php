<style type="text/css">.footer {
    background: #fff;
    border-top: 1px solid #e9ecef;    padding: 15px 20px;
}</style>
<footer class="footer">
                   @Copyright - 2021 , All right reserved by G-Devs (G-Developers).
            </footer>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/easion.js"></script>

   <!--  <script type="text/javascript" src="css/sweetalert/sweetalert.min.js"></script> -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <?php if(isset($_SESSION['msg'])){?>
<script type="text/javascript">
    $('.notifyjs-corner').empty();
    $.notify(
      '<?php echo $client_lang[$_SESSION["msg"]];?>',
      { position:"top center",className: '<?=$_SESSION["class"]?>'}
    );
</script>
<?php
    unset($_SESSION['msg']);
    unset($_SESSION['class']); 
    } 
?>   
</body>

</html>

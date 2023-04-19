<?php 
include('includes/header.php');
include('includes/navbar.php');
?>


<div class="container">
<div class="text-center mt-5 mb-4"style="justify-content:center; align-content:center;">
<h2>Ricerca dai post</h2>

<input type="text" class="form-control mt-5 mb-4" id="live_search" autocomplete="off" placeholder="...Ricerca qui...">
</div>

<div id="searchresult">  </div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<?php    if(isset($_SESSION['auth']) && ($_SESSION['auth_role']== 1 || $_SESSION['auth_role']== 2 )){ ?>

<script type="text/javascript">

$(document).ready(function(){

    $("#live_search").keyup(function(){
        var input = $(this).val();
        //alert(input); condizione in cui la barra di ricerca non è vuota
        if(input != ""){
            $.ajax({
                //prende il codice dal searchcode.php
                url:"searchcode.php",
                //il suo metodo 
                method:"POST",
                // prende l'input che l'utente ha scritto nella barra di ricerca
                data:{input:input},
                
                //se trova il risultato
                success:function(data){
                    //fai vedere nella parte di searchresult data
                    $("#searchresult").html(data);
                    //lo stile di css lo assegniamo x non mostrare il risultato
                    $("#searchresult").css("display","block");

                }
            });
            // se l'input è vuoto vuol dire che l'utente non ha scritto niente nella barra di ricerca
        }else {
            $("#searchresult").css("display","none");
        }
    });
});
    </script>
<?php } else{ ?>

<script type="text/javascript">

$(document).ready(function(){

    $("#live_search").keyup(function(){
        var input = $(this).val();
        //alert(input); condizione in cui la barra di ricerca non è vuota
        if(input != ""){
            $.ajax({
                //prende il codice dal searchcode.php
                url:"searchcodeguest.php",
                //il suo metodo 
                method:"POST",
                // prende l'input che l'utente ha scritto nella barra di ricerca
                data:{input:input},
                
                //se trova il risultato
                success:function(data){
                    //fai vedere nella parte di searchresult data
                    $("#searchresult").html(data);
                    //lo stile di css lo assegniamo x non mostrare il risultato
                    $("#searchresult").css("display","block");

                }
            });
            // se l'input è vuoto vuol dire che l'utente non ha scritto niente nella barra di ricerca
        }else {
            $("#searchresult").css("display","none");
        }
    });
});
    </script>
<?php } ?>

<?php 
include('includes/footer.php');
?>


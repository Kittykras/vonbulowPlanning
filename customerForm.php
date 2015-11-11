<?php
include 'include/sessionCheck.php';
include 'include/top.inc.php';
include 'include/menubar.inc.php';
include 'database/branchHandler.php';
?>
<link rel="stylesheet" href="./styles/input-styles.css">
<div class="container dcenter hpic img-responsive">
    <div class="section group">
        <div class="col span_1_of_2">
            <h4 class="chead" id="editH4"><span class="header-img">Opret Kunde</span></h4>
            <h2 class="chead" id="editH2"><span class="header-img">Opret Kunde</span></h2>
        </div>
        <br>
        <div class="col span_1_of_2" align="right">
            <button type="submit" form="form" class="btn btn-black" id="btnCreate" onsubmit="selectAll()">Opret Kunde</button>
            <button type="submit" form="form" class="btn btn-black hidden" formaction="database/actions/alterCustomer.php" id="btnAlter">Rediger Kunde</button>
        </div>
    </div>
</div>
<div class="vertically-align" align="center">
    <form id="form"role="form" action="database/actions/createCustomer.php" method="post">
        <div class="form-group">
            <input name="name" type="text" class="form-control input-style" id="name" placeholder="Navn">
        </div>
        <div class="form-group">
            <input name="acro" type="text" class="form-control input-style" id="acro" placeholder="Forkortelse (max 5 bogstaver)">
        </div>
        <div class="form-group">
            <input name="cont" type="text" class="form-control input-style" id="cont" placeholder="Kontaktperson">
        </div>
        <div class="form-group">
            <input name="tlf" type="text" class="form-control input-style" id="tlf" placeholder="Telefon">
        </div>
        <div class="form-group">
            <input name="mail" type="email" class="form-control input-style" id="mail" placeholder="Email">
        </div>
        <div id="branchHolder" class='form-group'>
            <select class="form-control input-style" name='bran' id="bran" onchange="openModal(this.value)">
                <?php
                foreach ($branches as $branch) {
                    ?>
                    <option value="<?php echo $branch->b_title; ?>"><?php echo $branch->b_title; ?></option>
                    <?php
                }
                ?>
                <option value="newBranch">Ny Branche</option>
            </select>
        </div>
        <div class='form-group'>
            <select class="form-control input-style" name='assi' id="assi">
                <?php
                foreach ($users as $user) {
                    ?>    
                    <option value="<?php echo $user->a_username; ?>"><?php echo $user->a_name; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div id="dest">
            <div class="form-group">
                <input type="text" name="url" class="form-control input-style" id="url" placeholder="Link">
            </div>
            <div class="form-group">
                <input type="text" name="user" class="form-control input-style" id="user" placeholder="Brugernavn">
            </div>
            <div class=" form-group group">
                <div class="form-group col span_1_of_2">
                    <input type="text" name="pwd" class="form-control input-style" id="pwd" placeholder="Adgangskode">
                </div>
                <div class="form-group col span_1_of_2">
                    <button type="button" class="btn btn-black" onclick="addLink()">Tilføj link</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="branchModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3>Opret Branche</h3>
            </div>
            <div class="modal-body">
                <input class="form-control input-style" type="text" id="branch" placeholder="Branche">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-black" onclick="updateBranch()">Opret</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="cName" name="cName" value="<?php echo $_SESSION["Kunde"]->c_name ?>"/>
<input type="hidden" id="cAcro" name="cAcro" value="<?php echo $_SESSION["Kunde"]->c_acronym ?>"/>
<input type="hidden" id="cCont" name="cCont" value="<?php echo $_SESSION["Kunde"]->c_conperson ?>"/>
<input type="hidden" id="cTlf" name="cTlf" value="<?php echo $_SESSION["Kunde"]->c_connumber ?>"/>
<input type="hidden" id="cMail" name="cMail" value="<?php echo $_SESSION["Kunde"]->c_conmail ?>"/>
<input type="hidden" id="cBran" name="cBran" value="<?php echo $_SESSION["Kunde"]->c_branch ?>"/>
<input type="hidden" id="cAssi" name="cAssi" value="<?php echo $_SESSION["Kunde"]->c_assigned ?>"/>
<?php
//echo $_GET["editing"];
if (isset($_GET["error"])) {
    if (isset($_GET["editing"])) {
        ?>
        <div class="vertically-align" align="center">
            <span class="text-danger">Der er sket en fejl i redigeringen af kunde. Tjek at alle felter er udfyldt, eller, hvis du er ved at ændre forkortelse, om det nye forkortelse er på max 5 bogstaver, eller evt. allerede eksisterer.</span>
        </div>
        <?php
    } else {
        ?>
        <div class="vertically-align" align="center">
            <span class="text-danger">Der er sket en fejl i oprettelsen af kunde. Tjek at alle felter er udfyldt, og om forkortelsen er på max 5 bogstaver, eller evt. allerede eksisterer.</span>
        </div>
        <?php
    }
}
?>
<script language="javascript" type="text/javascript">
    var urls=[];
    function addLink() {
        var url = document.getElementById('url').value;
        var user = document.getElementById('user').value;
        var pwd = document.getElementById('pwd').value;
        var dest = {url: url, user: user, pwd: pwd};
        urls.push(dest);
        var json = JSON.stringify(urls);
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                document.getElementById("dest").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "database/actions/addLink.php?q=" + json, true);
        xmlhttp.send();
    }
    function updateBranch() {
        var val = document.getElementById('branch').value;
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                document.getElementById("branchHolder").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "database/actions/createBranch.php?q=" + val, true);
        xmlhttp.send();
        $('#branchModal').modal('hide');
    }
    function openModal(value) {
        if (value === 'newBranch') {
            $('#branchModal').modal('show');
        }
    }
    var $_GET = {};

    document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
        function decode(s) {
            return decodeURIComponent(s.split("+").join(" "));
        }

        $_GET[decode(arguments[1])] = decode(arguments[2]);
    });
    $(document).ready(function () {
        if ($_GET["editing"] === "edit") {
            var name = $('#cName').val();
            var acro = $('#cAcro').val();
            var cont = $('#cCont').val();
            var tlf = $('#cTlf').val();
            var mail = $('#cMail').val();
            var bran = $('#cBran').val();
            var assi = $('#cAssi').val();
            document.getElementById("editH4").innerHTML = "Rediger Kunde";
            document.getElementById("editH2").innerHTML = "Rediger Kunde";
            $("button#btnAlter").removeClass("hidden");
            $("button#btnCreate").addClass("hidden");
            document.getElementById("name").value = name;
            document.getElementById("acro").value = acro;
            document.getElementById("cont").value = cont;
            document.getElementById("tlf").value = tlf;
            document.getElementById("mail").value = mail;
            document.getElementById("bran").value = bran;
            document.getElementById("assi").value = assi;
        }
    });
</script>
</body>
</html><?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


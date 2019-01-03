<!DOCTYPE html>
<html lang="pt_br">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <link rel="icon" href="resources/icon.png" type="image/gif" sizes="16x16">
  <title>Mapa LGBTQ+</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


  <!-- Map Icons -->
  <link rel="stylesheet" type="text/css" href="dist/css/map-icons.css">
  <script type="text/javascript" src="dist/js/map-icons.js"></script>

  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

  <style>
    .col-container {
        display: table;
        width: 100%;
    }
    .col-t {
        display: table-cell;
   }
   .right-card {
      margin-left: -10%;
        width: 100%;
      padding-bottom: 50%;
   }
   .page-body {
      min-height: 95vh;
   }
   .THE-background {
      content: "";
      /*background: url(resources/wallpapper-2.png);
      background-size: 100px;*/
      background: url(resources/wallpapper.jpg);
      opacity: 0.2;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
      position: fixed;
      z-index: -1;
    }

a, .dropdown-content li > span {
    font-size: 16px;
    color: #9c27b0;
    display: block;
    line-height: 22px;
    padding: 14px 16px;
}

.select-wrapper input.select-dropdown:focus {
    border-bottom: 1px solid #9c27b0;
}

#map {
        height: 100%;
      }
  </style>


<script src="https://www.gstatic.com/firebasejs/5.5.5/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyD5HNHLNi-49Hii8baBDNUqEsbihkIxZJg",
    authDomain: "mapa-lgbt.firebaseapp.com",
    databaseURL: "https://mapa-lgbt.firebaseio.com",
    projectId: "mapa-lgbt",
    storageBucket: "mapa-lgbt.appspot.com/",
    messagingSenderId: "762565031872"
  };
  firebase.initializeApp(config);
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlhQDNPvPu9NneGUsZCidnCnWKJISZj_8&libraries=places&callback=initAutocomplete"></script>
    <script>
      // In the following example, markers appear when the user clicks on the map.
      // Each marker is labeled with a single alphabetical character.
      var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      var labelIndex = 0;

      var map;
      var submap;
      var marker;
      var markers = [];
      var submarker;
      var submarkers = [];
      var clickLocation;
      var nnegativos = 0;
      var npositivos = 0;
      var database = firebase.database();
      var DBPositivo = firebase.database().ref('Positivo/');
      var DBNegativo = firebase.database().ref('Negativo/');
      var currentCase;
      var resp = {};

      var VarUserHomo = false;
      var VarUserHetero =  false;
      var VarUserBi =  false;
      var VarUserA =  false;
      var VarUserDemi =  false;
      var VarUserPan =  false;
      var VarUserPoli =  false;
      var VarUserTrans =  false;
      var VarUserCis =  false;
      var VarUserGeneroNeutro =  false;
      var VarUserAgenero =  false;
      var VarUserHomem =  false;
      var VarUserMulher =  false;
      var VarUserTravesti =  false;
      var VarUserMultiplos =  false;
      var VarNegativoAgressaoFisica =  false;
      var VarNegativoAgressaoVerbal =  false;
      var VarNegativoAmeacaAgressao =  false;
      var VarNegativoMachismo =  false;
      var VarNegativoHomofobia =  false;
      var VarNegativoTransfobia =  false;
      var VarNegativoDestratar =  false;
      var VarNegativoLesbofobia =  false;
      var VarNegativoMansplaning =  false;
      var VarNegativoDesconsiderar =  false;
      var VarNegativoEstereotipacao =  false;
      var VarNegativoPiadinha =  false;
      var VarPositivoTratamentoIgualitario =  false;
      var VarPositivoApoioPublico =  false;
      var VarPositivoAcomodacaoInclusiva =  false;
      var VarPositivoEventosLGBTQ =  false;
      var VarPositivoRespeitoTrans =  false;
      var VarPositivoRepudioLGBTfobia =  false;
      var VarPositivoVisibilidadeLGBTfobia =  false;


        var PCases = {};

      var PurpleStar = {
        path: 'M 125,5 155,90 245,90 175,145 200,230 125,180 50,230 75,145 5,90 95,90 z',
        fillColor: 'purple',
        fillOpacity: 0.5,
        scale: 0.1,
        strokeWeight: 0
      };

      var PurplePin = {
        path: mapIcons.shapes.MAP_PIN,
        fillColor: '#E040FB',
        fillOpacity: 0.3,
        scale: 0.7,
        strokeWeight: 0
      };

      var PinkPin = {
        path: mapIcons.shapes.MAP_PIN,
        fillColor: 'pink',
        fillOpacity: 0.3,
        scale: 0.7,
        strokeWeight: 0
      };

      var BlackPin = {
        path: mapIcons.shapes.MAP_PIN,
        fillColor: 'black',
        fillOpacity: 0.3,
        scale: 0.7,
        strokeWeight: 0
      };

      var BlueStar = {
        path: 'M 125,5 155,90 245,90 175,145 200,230 125,180 50,230 75,145 5,90 95,90 z',
        fillColor: 'blue',
        fillOpacity: 0.5,
        scale: 0.1,
        strokeWeight: 0
      };

      var RedStar = {
        path: 'M 125,5 155,90 245,90 175,145 200,230 125,180 50,230 75,145 5,90 95,90 z',
        fillColor: 'red',
        fillOpacity: 0.5,
        scale: 0.1,
        strokeWeight: 0
      };

      function clearFields(){
        $('#UserIdade').val(' ');
        $('#descricaoPositiva').val(' ');
        $('#descricaoNegativo').val(' ');
        $('#EstabelecimentoInput').val(' ');

        $('#UserHomo').prop('checked', false);
        $('#UserHetero').prop('checked', false);
        $('#UserBi').prop('checked', false);
        $('#UserA').prop('checked', false);
        $('#UserDemi').prop('checked', false);
        $('#UserPan').prop('checked', false);
        $('#UserPoli').prop('checked', false);
        $('#UserTrans').prop('checked', false);
        $('#UserCis').prop('checked', false);
        $('#UserGeneroNeutro').prop('checked', false);
        $('#UserAgenero').prop('checked', false);
        $('#UserHomem').prop('checked', false);
        $('#UserMulher').prop('checked', false);
        $('#UserTravesti').prop('checked', false);
        $('#UserMultiplos').prop('checked', false);
        $('#NegativoAgressaoFisica').prop('checked', false);
        $('#NegativoAgressaoVerbal').prop('checked', false);
        $('#NegativoAmeacaAgressao').prop('checked', false);
        $('#NegativoMachismo').prop('checked', false);
        $('#NegativoHomofobia').prop('checked', false);
        $('#NegativoTransfobia').prop('checked', false);
        $('#NegativoDestratar').prop('checked', false);
        $('#NegativoLesbofobia').prop('checked', false);
        $('#NegativoMansplaning').prop('checked', false);
        $('#NegativoDesconsiderar').prop('checked', false);
        $('#NegativoEstereotipacao').prop('checked', false);
        $('#NegativoPiadinha').prop('checked', false);
        $('#PositivoTratamentoIgualitario').prop('checked', false);
        $('#PositivoApoioPublico').prop('checked', false);
        $('#PositivoAcomodacaoInclusiva').prop('checked', false);
        $('#PositivoEventosLGBTQ').prop('checked', false);
        $('#PositivoRespeitoTrans').prop('checked', false);
        $('#PositivoRepudioLGBTfobia').prop('checked', false);
        $('#PositivoVisibilidadeLGBTfobia').prop('checked', false);


        document.getElementById('RelatoForm1').style.display = 'none';
        document.getElementById('RelatoForm2Pos').style.display = 'none';
        document.getElementById('RelatoForm2Neg').style.display = 'none';
        document.getElementById('RelatoForm3').style.display = 'none';
        document.getElementById('npositivos').innerHTML = npositivos;
        document.getElementById('nnegativos').innerHTML = nnegativos;


      }


      function addRegistro(){

        var UserIdade = document.getElementById('UserIdade');
        var descricaoPositiva = document.getElementById('descricaoPositiva');
        var descricaoNegativo = document.getElementById('descricaoNegativo');
        var Estabelecimento = document.getElementById('EstabelecimentoInput');

        var UserHomo = document.getElementById('UserHomo');
        var UserHetero = document.getElementById('UserHetero');
        var UserBi = document.getElementById('UserBi');
        var UserA = document.getElementById('UserA');
        var UserDemi = document.getElementById('UserDemi');
        var UserPan = document.getElementById('UserPan');
        var UserPoli = document.getElementById('UserPoli');
        var UserTrans = document.getElementById('UserTrans');
        var UserCis = document.getElementById('UserCis');
        var UserGeneroNeutro = document.getElementById('UserGeneroNeutro');
        var UserAgenero = document.getElementById('UserAgenero');
        var UserHomem = document.getElementById('UserHomem');
        var UserMulher = document.getElementById('UserMulher');
        var UserTravesti = document.getElementById('UserTravesti');
        var UserMultiplos = document.getElementById('UserMultiplos');
        var NegativoAgressaoFisica = document.getElementById('NegativoAgressaoFisica');
        var NegativoAgressaoVerbal = document.getElementById('NegativoAgressaoVerbal');
        var NegativoAmeacaAgressao = document.getElementById('NegativoAmeacaAgressao');
        var NegativoMachismo = document.getElementById('NegativoMachismo');
        var NegativoHomofobia = document.getElementById('NegativoHomofobia');
        var NegativoTransfobia = document.getElementById('NegativoTransfobia');
        var NegativoDestratar = document.getElementById('NegativoDestratar');
        var NegativoLesbofobia = document.getElementById('NegativoLesbofobia');
        var NegativoMansplaning = document.getElementById('NegativoMansplaning');
        var NegativoDesconsiderar = document.getElementById('NegativoDesconsiderar');
        var NegativoEstereotipacao = document.getElementById('NegativoEstereotipacao');
        var NegativoPiadinha = document.getElementById('NegativoPiadinha');
        var PositivoTratamentoIgualitario = document.getElementById('PositivoTratamentoIgualitario');
        var PositivoApoioPublico = document.getElementById('PositivoApoioPublico');
        var PositivoAcomodacaoInclusiva = document.getElementById('PositivoAcomodacaoInclusiva');
        var PositivoEventosLGBTQ = document.getElementById('PositivoEventosLGBTQ');
        var PositivoRespeitoTrans = document.getElementById('PositivoRespeitoTrans');
        var PositivoRepudioLGBTfobia = document.getElementById('PositivoRepudioLGBTfobia');
        var PositivoVisibilidadeLGBTfobia = document.getElementById('PositivoVisibilidadeLGBTfobia');

        if( UserHomo.checked == true ){ VarUserHomo = true};
        if( UserHetero.checked == true ){ VarUserHetero = true};
        if( UserBi.checked == true ){ VarUserBi = true};
        if( UserA.checked == true ){ VarUserA = true};
        if( UserDemi.checked == true ){ VarUserDemi = true};
        if( UserPan.checked == true ){ VarUserPan = true};
        if( UserPoli.checked == true ){ VarUserPoli = true};
        if( UserTrans.checked == true ){ VarUserTrans = true};
        if( UserCis.checked == true ){ VarUserCis = true};
        if( UserGeneroNeutro.checked == true ){ VarUserGeneroNeutro = true};
        if( UserAgenero.checked == true ){ VarUserAgenero = true};
        if( UserHomem.checked == true ){ VarUserHomem = true};
        if( UserMulher.checked == true ){ VarUserMulher = true};
        if( UserTravesti.checked == true ){ VarUserTravesti = true};
        if( UserMultiplos.checked == true ){ VarUserMultiplos = true};
        if( NegativoAgressaoFisica.checked == true ){ VarNegativoAgressaoFisica = true};
        if( NegativoAgressaoVerbal.checked == true ){ VarNegativoAgressaoVerbal = true};
        if( NegativoAmeacaAgressao.checked == true ){ VarNegativoAmeacaAgressao = true};
        if( NegativoMachismo.checked == true ){ VarNegativoMachismo = true};
        if( NegativoHomofobia.checked == true ){ VarNegativoHomofobia = true};
        if( NegativoTransfobia.checked == true ){ VarNegativoTransfobia = true};
        if( NegativoDestratar.checked == true ){ VarNegativoDestratar = true};
        if( NegativoLesbofobia.checked == true ){ VarNegativoLesbofobia = true};
        if( NegativoMansplaning.checked == true ){ VarNegativoMansplaning = true};
        if( NegativoDesconsiderar.checked == true ){ VarNegativoDesconsiderar = true};
        if( NegativoEstereotipacao.checked == true ){ VarNegativoEstereotipacao = true};
        if( NegativoPiadinha.checked == true ){ VarNegativoPiadinha = true};
        if( PositivoTratamentoIgualitario.checked == true ){ VarPositivoTratamentoIgualitario = true};
        if( PositivoApoioPublico.checked == true ){ VarPositivoApoioPublico = true};
        if( PositivoAcomodacaoInclusiva.checked == true ){ VarPositivoAcomodacaoInclusiva = true};
        if( PositivoEventosLGBTQ.checked == true ){ VarPositivoEventosLGBTQ = true};
        if( PositivoRespeitoTrans.checked == true ){ VarPositivoRespeitoTrans = true};
        if( PositivoRepudioLGBTfobia.checked == true ){ VarPositivoRepudioLGBTfobia = true};
        if( PositivoVisibilidadeLGBTfobia.checked == true ){ VarPositivoVisibilidadeLGBTfobia = true};

if( submarkers.length == 1){
          

        if(currentCase == 'Positivo'){
          npositivos++;
          var json = {
            lat: submarkers[0].position.lat(),
            lng: submarkers[0].position.lng(),
            state: currentCase,
            multiplos : VarUserMultiplos ,
            resp: {
              'VarUserHomo' : VarUserHomo ,
              'VarUserHetero' : VarUserHetero ,
              'VarUserBi' : VarUserBi ,
              'VarUserA' : VarUserA ,
              'VarUserDemi' : VarUserDemi ,
              'VarUserPan' : VarUserPan ,
              'VarUserPoli' : VarUserPoli ,
              'VarUserTrans' : VarUserTrans ,
              'VarUserCis' : VarUserCis ,
              'VarUserGeneroNeutro' : VarUserGeneroNeutro ,
              'VarUserAgenero' : VarUserAgenero ,
              'VarUserHomem' : VarUserHomem ,
              'VarUserMulher' : VarUserMulher  ,
              'VarUserTravesti' : VarUserTravesti ,
              'VarPositivoTratamentoIgualitario' : VarPositivoTratamentoIgualitario ,
              'VarPositivoApoioPublico' : VarPositivoApoioPublico ,
              'VarPositivoAcomodacaoInclusiva' : VarPositivoAcomodacaoInclusiva ,
              'VarPositivoEventosLGBTQ' : VarPositivoEventosLGBTQ ,
              'VarPositivoRespeitoTrans' : VarPositivoRespeitoTrans ,
              'VarPositivoRepudioLGBTfobia' : VarPositivoRepudioLGBTfobia ,
              'VarPositivoVisibilidadeLGBTfobia' : VarPositivoVisibilidadeLGBTfobia
            },
            Descricao : descricaoPositiva.value,
            Idade : UserIdade.value ,
            Estabelecimento : Estabelecimento.value
          };
          
          NewCase = DBPositivo.push();
          NewCase.set(json);
          addMarker(submarkers[0].position , map, PurplePin, NewCase.key , json);
          clearFields(); 
          


        }else {
          nnegativos++;
          var json =  {
            lat: submarkers[0].position.lat(),
            lng: submarkers[0].position.lng(),
            state: currentCase,
            multiplos : VarUserMultiplos ,
            resp: {
              'VarUserHomo' : VarUserHomo ,
              'VarUserHetero' : VarUserHetero ,
              'VarUserBi' : VarUserBi ,
              'VarUserA' : VarUserA ,
              'VarUserDemi' : VarUserDemi ,
              'VarUserPan' : VarUserPan ,
              'VarUserPoli' : VarUserPoli ,
              'VarUserTrans' : VarUserTrans ,
              'VarUserCis' : VarUserCis ,
              'VarUserGeneroNeutro' : VarUserGeneroNeutro ,
              'VarUserAgenero' : VarUserAgenero ,
              'VarUserHomem' : VarUserHomem ,
              'VarUserMulher' : VarUserMulher  ,
              'VarUserTravesti' : VarUserTravesti ,
              'VarNegativoAgressaoFisica' : VarNegativoAgressaoFisica ,
              'VarNegativoAgressaoVerbal' : VarNegativoAgressaoVerbal ,
              'VarNegativoAmeacaAgressao' : VarNegativoAmeacaAgressao ,
              'VarNegativoMachismo' : VarNegativoMachismo ,
              'VarNegativoHomofobia' : VarNegativoHomofobia ,
              'VarNegativoTransfobia' : VarNegativoTransfobia ,
              'VarNegativoDestratar' : VarNegativoDestratar ,
              'VarNegativoLesbofobia' : VarNegativoLesbofobia ,
              'VarNegativoMansplaning' : VarNegativoMansplaning ,
              'VarNegativoDesconsiderar' : VarNegativoDesconsiderar ,
              'VarNegativoEstereotipacao' : VarNegativoEstereotipacao ,
              'VarNegativoPiadinha' : VarNegativoPiadinha
            },
            Descricao : descricaoNegativo.value,
            Idade : UserIdade.value ,
            Estabelecimento : Estabelecimento.value
          };

          
          NewCase = DBNegativo.push();
          NewCase.set(json);
          addMarker(submarkers[0].position , map, BlackPin, NewCase.key , json);
          clearFields(); 
        
          //addMarker(clickLocation , map, BlackPin, NewCase.key , json);

          

        }

        }else{
  alert("Por gentileza, escolha apenas um ponto");
}

        

      }

      // Adds a marker to the map.
      function addMarker(location, map , color , markerkey , markerData) {
        // Add the marker at the clicked location, and add the next-available label
        // from the array of alphabetical characters.
        marker = new google.maps.Marker({
          position: location,
          icon: color,
          map: map,
          key: markerkey,
          data: markerData
        });
        marker.addListener('click', function() {

          $('#RelatoDisplay').show();




          if(this.data.state == "Positivo"){
            $('#DetalhesTitle').toggleClass('blue-text' , true);
            $('#DetalhesTitle').toggleClass('red-text' , false);
            $('#RelatoCard').toggleClass('red' , false);
            $('#RelatoCard').toggleClass('blue' , true);

            $( "#GenderField" ).html(" ");
            $( "#RelatoField" ).html(" ");

            if(this.data.resp.VarUserHomo){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Homosexual</p>");}
            if(this.data.resp.VarUserHetero){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Heterosexual</p>");}
            if(this.data.resp.VarUserBi){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Bisexual</p>");}
            if(this.data.resp.VarUserA){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Asexual</p>");}
            if(this.data.resp.VarUserDemi){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Demisexual</p>");}
            if(this.data.resp.VarUserPan){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Pansexual</p>");}
            if(this.data.resp.VarUserPoli){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Polisexual</p>");}
            if(this.data.resp.VarUserTrans){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Trans</p>");}
            if(this.data.resp.VarUserCis){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Cis</p>");}
            if(this.data.resp.VarUserGeneroNeutro){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Gênero Neutro</p>");}
            if(this.data.resp.VarUserAgenero){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Agênero</p>");}
            if(this.data.resp.VarUserHomem){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Homem</p>");}
            if(this.data.resp.VarUserMulher){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Mulher</p>");}
            if(this.data.resp.VarUserTravesti){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Travesti</p>");}

            if(this.data.resp.VarPositivoTratamentoIgualitario){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Tratamento igualitário para casal LGBTQ</p>");}
            if(this.data.resp.VarPositivoApoioPublico){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Manifestação pública de apoio à causa LGBTQ</p>");}
            if(this.data.resp.VarPositivoAcomodacaoInclusiva){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Acomodação inclusiva para pessoas trans</p>");}
            if(this.data.resp.VarPositivoEventosLGBTQ){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Organizar eventos pro LGBTQ</p>");}
            if(this.data.resp.VarPositivoRespeitoTrans){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Respeito à permanência da pessoa trans em local designado ao gênero com o qual se identifica</p>");}
            if(this.data.resp.VarPositivoRepudioLGBTfobia){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Manifestação publica de repudio a atitude LGBTfobica</p>");}
            if(this.data.resp.VarPositivoVisibilidadeLGBTfobia){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Levantar visibilidade sobre a questão da LGBTfobia</p>");}

            if(this.data.multiplos){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Mais de uma pessoa envolvida</p>");}

          }else{
            $('#DetalhesTitle').toggleClass('blue-text' , false);
            $('#DetalhesTitle').toggleClass('red-text' , true);
            $('#RelatoCard').toggleClass('red' , true);
            $('#RelatoCard').toggleClass('blue' , false);

            $( "#GenderField" ).html(" ");
            $( "#RelatoField" ).html(" ");

            if(this.data.resp.VarUserHomo){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Homosexual</p>");}
            if(this.data.resp.VarUserHetero){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Heterosexual</p>");}
            if(this.data.resp.VarUserBi){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Bisexual</p>");}
            if(this.data.resp.VarUserA){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Asexual</p>");}
            if(this.data.resp.VarUserDemi){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Demisexual</p>");}
            if(this.data.resp.VarUserPan){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Pansexual</p>");}
            if(this.data.resp.VarUserPoli){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Polisexual</p>");}
            if(this.data.resp.VarUserTrans){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Trans</p>");}
            if(this.data.resp.VarUserCis){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Cis</p>");}
            if(this.data.resp.VarUserGeneroNeutro){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Gênero Neutro</p>");}
            if(this.data.resp.VarUserAgenero){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Agênero</p>");}
            if(this.data.resp.VarUserHomem){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Homem</p>");}
            if(this.data.resp.VarUserMulher){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Mulher</p>");}
            if(this.data.resp.VarUserTravesti){$( "#GenderField" ).html($( "#GenderField" ).html() + "<p>Travesti</p>");}

            if(this.data.resp.VarNegativoAgressaoFisica){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Agressão física</p>");}
            if(this.data.resp.VarNegativoAgressaoVerbal){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Agressão verbal</p>");}
            if(this.data.resp.VarNegativoAmeacaAgressao){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Ameaça de agressão</p>");}
            if(this.data.resp.VarNegativoHomofobia){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Homofobia</p>");}
            if(this.data.resp.VarNegativoMachismo){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Machismo</p>");}
            if(this.data.resp.VarNegativoTransfobia){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Transfobia</p>");}
            if(this.data.resp.VarNegativoDestratar){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Destratar</p>");}
            if(this.data.resp.VarNegativoLesbofobia){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Lesbofobia</p>");}
            if(this.data.resp.VarNegativoMansplaning){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Mansplaning</p>");}
            if(this.data.resp.VarNegativoDesconsiderar){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Desconsiderar minha capacidade</p>");}
            if(this.data.resp.VarNegativoEstereotipacao){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Estereotipação</p>");}
            if(this.data.resp.VarNegativoPiadinha){$( "#RelatoField" ).html($( "#RelatoField" ).html() + "<p>Piadinha LGBTQfóbica</p>");}

          }
          $('#IdadeInput').val(this.data.Idade);
          $('#DescricaoInput').val(this.data.Descricao);
          M.textareaAutoResize($('#DescricaoInput'));
          $('#LocalInput').val(this.data.Estabelecimento);
        });
        markers.push(marker);
      }

      function addSubMarker(location, map) {
        // Add the marker at the clicked location, and add the next-available label
        // from the array of alphabetical characters.
        submarker = new google.maps.Marker({
          position: location,
          map: map
        });
        submarker.addListener('click', function(){
          currentPosition = this.position;
          deleteSubMarkers();
          addSubMarker(currentPosition, submap);
          submap.setCenter(currentPosition);
          clickLocation = currentPosition;
        });
        submarkers.push(submarker);
      }

      // Sets the map on all markers in the array.
      function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }

      // Sets the map on all markers in the array.
      function setSubMapOnAll(map) {
        for (var i = 0; i < submarkers.length; i++) {
          submarkers[i].setMap(map);
        }
      }

      // Removes the markers from the map, but keeps them in the array.
      function clearSubMarkers() {
        setSubMapOnAll(null);
      }

      // Shows any markers currently in the array.
      function showSubMarkers() {
        setSubMapOnAll(submap);
      }

      // Deletes all markers in the array by removing references to them.
      function deleteSubMarkers() {
        clearSubMarkers();
        submarkers = [];
      }

      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
      }

      // Shows any markers currently in the array.
      function showMarkers() {
        setMapOnAll(submap);
      }

      // Deletes all markers in the array by removing references to them.
      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }

      function initialize() {
        var location = { lat: -23.550278 , lng:  -46.633889 };
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center:location
        });

        submap = new google.maps.Map(document.getElementById('submap'), {
          zoom: 12,
          center:location
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        // This event listener calls addMarker() when the map is clicked.

        google.maps.event.addListener(submap, 'click', function(event) {
          
          submap.setCenter(event.latLng);
          clickLocation = event.latLng;
          deleteSubMarkers();
          addSubMarker(event.latLng, submap);
        });

        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              title: place.name,
              position: place.geometry.location
            }));

            deleteSubMarkers();
            addSubMarker(place.geometry.location, submap);

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });

        // Create the search box and link it to the UI element.
        var subinput = document.getElementById('subpac-input');
        var SubSearchBox = new google.maps.places.SearchBox(subinput);
        //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        submap.addListener('bounds_changed', function() {
          SubSearchBox.setBounds(map.getBounds());
        });

        // This event listener calls addMarker() when the map is clicked.

        google.maps.event.addListener(submap, 'click', function(event) {
          deleteSubMarkers();
          addSubMarker(event.latLng, submap);
          submap.setCenter(event.latLng);
          clickLocation = event.latLng;
        });

        SubSearchBox.addListener('places_changed', function() {
          var places = SubSearchBox.getPlaces();

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }

            // Create a marker for each place.
addSubMarker(place.geometry.location, submap);
/*
            submarkers.push(new google.maps.Marker({
              map: submap,
              title: place.name,
              position: place.geometry.location
            }));
*/
            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          submap.fitBounds(bounds);
        });

        // Add a marker at the center of the map.
        DBNegativo.once('value', function(snapshot) {
          snapshot.forEach(function(childSnapshot) {
            PCases = childSnapshot.val();
            location = { lat: Number(PCases.lat) , lng:  Number(PCases.lng) };
            console.log(childSnapshot.key);
            addMarker(location, map , BlackPin , childSnapshot.key , PCases);
            nnegativos++;
          });
          document.getElementById('nnegativos').innerHTML = nnegativos;
        });
        DBPositivo.once('value', function(snapshot) {
          snapshot.forEach(function(childSnapshot) {
            PCases = childSnapshot.val();
            location = { lat: Number(PCases.lat) , lng:  Number(PCases.lng) };
            addMarker(location, map , PurplePin , childSnapshot.key , PCases);
            npositivos++;
          });
          document.getElementById('npositivos').innerHTML = npositivos;
        });

      }

      function switchDisplay(){


      }

      google.maps.event.addDomListener(window, 'load', initialize);

    </script>
</head>
<body style="width: 100%;"><!--
  <nav class="white" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Logo</a>
      <ul class="right hide-on-med-and-down">
        <li><a class="blue-text" href="#SobreNos">Sobre Nós</a></li>
        <li><a class="blue-text" href="#Produtos">Produtos e Serviços</a></li>
      </ul>

      <ul id="nav-mobile" class="sidenav">
        <li><a class="blue-text" href="#SobreNos">Sobre Nós</a></li>
        <li><a class="blue-text" href="#Produtos">Produtos e Serviços</a></li>
        <li><a class="blue-text" href="#Parceiros">Parceiros</a></li>
      </ul>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger blue-text text-darken-3"><i class="material-icons">menu</i></a>
    </div>
  </nav>-->
  <div class="THE-background"></div>
<div class="page-body">
  <div class="section no-pad-bot hide-on-med-and-down" id="index-banner" style="padding-top: 0px; margin-top: -30px;">
    <div class="container" style="padding-top: 0px">
      <div class="row" style="padding-top: 0px">
        <div class="col-container">
          <div class="col-t m4 s12" style=" padding-top: 0px;">
            <div class="card white" style="z-index: 100;">
                  <div class="card-content purple-text darken-2">
                      <h2 class="light">Portal LGBTQ+</h2>

                  </div>
            </div>
          </div>

          <div class="col-t m1 s12 " >
            <div class="card right-card pink" style="z-index: 90">
                  <div class="card-content pink-text darken-2">
                      <h4 class="light"></h4>

                  </div>
            </div>
          </div>

          <div class="col-t m1 s12  ">
            <div class="card right-card red"  style="z-index: 80">
                  <div class="card-content red-text">
                      <h4 class="light"></h4>

                  </div>
            </div>
          </div>

          <div class="col-t m1 s12  ">
            <div class="card right-card orange" style="z-index: 70">
                  <div class="card-content orange-text">
                      <h4 class="light"></h4>

                  </div>
            </div>
          </div>

          <div class="col-t m1 s12  ">
            <div class="card right-card yellow" style="z-index: 60">
                  <div class="card-content yellow-text">
                      <h4 class="light"></h4>

                  </div>
            </div>
          </div>

          <div class="col-t m1 s12  ">
            <div class="card right-card green" style="z-index: 50">
                  <div class="card-content blue-grey-text">
                      <h4 class="light"></h4>

                  </div>
            </div>
          </div>

          <div class="col-t m1 s12  ">
            <div class="card right-card teal" style="z-index: 40">
                  <div class="card-content blue-grey-text darken-2">
                      <h4 class="light"></h4>

                  </div>
            </div>
          </div>

          <div class="col-t m1 s12  ">
            <div class="card right-card cyan" style="z-index: 30">
                  <div class="card-content blue-grey-text darken-2">
                      <h4 class="light"></h4>

                  </div>
            </div>
          </div>

          <div class="col-t m1 s12  ">
            <div class="card right-card blue" style="z-index: 20">
                  <div class="card-content blue-grey-text darken-2">
                      <h4 class="light"></h4>

                  </div>
            </div>
          </div>

          <div class="col-t m1 s12  ">
            <div class="card right-card purple" style="z-index: 10">
                  <div class="card-content blue-grey-text darken-2">
                      <h4 class="light"></h4>

                  </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>


  <div class="section no-pad-bot hide-on-large-only" id="index-banner" style="padding-top: 0px; margin-top: -30px;">
    <div class="container" style="padding-top: 0px">
      <div class="row" style="padding-top: 0px">
        <div class="col-container">
          <div class="col-t m4 s12" style=" padding-top: 0px;">
            <div class="card white" style="z-index: 100;">
                  <div class="card-content purple-text darken-2">
                      <h2 class="light">Portal LGBTQ+</h2>

                  </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>


  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <div class="row">
        <div class="col m6 s12">
            <div class="card white" style="z-index: 100">
                  <div class="card-content purple-text darken-2">
                      <h4 class="light">Relatos Positivos</h4>
                      <h2 id="npositivos" class="blue-text">0</h2>

                  </div>
            </div>
          </div>
          <div class="col m6 s12">
            <div class="card white" style="z-index: 100">
                  <div class="card-content purple-text darken-2">
                      <h4 class="light">Relatos Negativos</h4>
                      <h2 id="nnegativos" class="red-text">0</h2>

                  </div>
            </div>
          </div>
      </div>

    </div>
  </div>

  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <div id="RelatoForm1" style="display: none" class="row">
        <form class="col s12">
            <div class="card white" style="z-index: 1000">
                  <div class="card-content purple-text darken-2">
                    <div class="row">


                        <h3>Dentre os termos abaixo, com quais você se identifica?</h3>
                        <div class="col l6 m6 s12">
                          <p>
                            <label>
                              <input id="UserHomo" type="checkbox" />
                              <span>Homosexual</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="UserHetero" type="checkbox" />
                              <span>Heterosexual</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="UserBi" type="checkbox" />
                              <span>Bisexual</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="UserA" type="checkbox" />
                              <span>Asexual</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="UserDemi" type="checkbox" />
                              <span>Demisexual</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="UserPan" type="checkbox" />
                              <span>Pansexual</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="UserPoli" type="checkbox" />
                              <span>Polisexual</span>
                            </label>
                          </p>
                        </div>
                        <div class="col l4 m6 s12">
                          <p>
                            <label>
                              <input id="UserTrans" type="checkbox" />
                              <span>Trans</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="UserCis" type="checkbox" />
                              <span>Cis</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="UserGeneroNeutro" type="checkbox" />
                              <span>Gênero neutro</span>
                            </label>
                          </p>
                            <p>
                            <label>
                              <input id="UserAgenero" type="checkbox" />
                              <span>Agênero</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="UserHomem" type="checkbox" />
                              <span>Homem</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="UserMulher" type="checkbox" />
                              <span>Mulher</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="UserTravesti" type="checkbox" />
                              <span>Travesti</span>
                            </label>
                          </p>
                        </div>
                        <div class="row">
                          <div class="col m6 s12">
                            <div class="input-field">
                            <input id="UserIdade" type="text" class="validate">
                            <label for="UserIdae">Idade</label>
                          </div>
                          </div>
                          <div class="col m6 s12">
                            <br><br>
                            <p>
                              <label>
                                <input id="UserMultiplos" type="checkbox" />
                                <span>Mais de uma vítima?</span>
                              </label>
                            </p>
                          </div>
                        </div>
                        <div class="col m6 s12">
                          <a class="waves-effect waves-light btn-large blue" style="width: 100%" onclick="document.getElementById('RelatoForm2Pos').style.display = 'inline'; document.getElementById('RelatoForm2Neg').style.display = 'none'; currentCase = 'Positivo'; ">Positivo</a>
                          <br/><br/>
                        </div>
                        <div class="col m6 s12">
                          <a class="waves-effect waves-light btn-large red" style="width: 100%" onclick="document.getElementById('RelatoForm2Neg').style.display = 'inline'; document.getElementById('RelatoForm2Pos').style.display = 'none'; currentCase = 'Negativo'; ">Negativo</a>
                        </div>


                        </div>

                  </div>
            </div>
          </form>
      </div>

    </div>
  </div>

   <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <div id="RelatoForm2Neg" style="display: none" class="row">
        <form class="col s12">
            <div class="card white" style="z-index: 1000">
                  <div class="card-content purple-text darken-2">

                        <h3>Nos conte mais sobre o que aconteceu</h3>

                        <div class="col m6 s12">
                          <p>
                            <label>
                              <input id="NegativoAgressaoFisica" type="checkbox" />
                              <span>Agressão física</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="NegativoAgressaoVerbal" type="checkbox" />
                              <span>Agressão verbal</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="NegativoAmeacaAgressao" type="checkbox" />
                              <span>Ameaça de agressão</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="NegativoHomofobia" type="checkbox" />
                              <span>Homofobia</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="NegativoMachismo" type="checkbox" />
                              <span>Machismo</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="NegativoTransfobia" type="checkbox" />
                              <span>Transfobia</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="NegativoDestratar" type="checkbox" />
                              <span>Destratar</span>
                            </label>
                          </p>
                        </div>
                        <div class="col m6 s12">
                          <p>
                            <label>
                              <input id="NegativoLesbofobia" type="checkbox" />
                              <span>Lesbofobia</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="NegativoMansplaning" type="checkbox" />
                              <span>Mansplaning</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="NegativoDesconsiderar" type="checkbox" />
                              <span>Desconsiderar minha capacidade</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="NegativoEstereotipacao" type="checkbox" />
                              <span>Estereotipação</span>
                            </label>
                          </p>
                          <p>
                            <label>
                              <input id="NegativoPiadinha" type="checkbox" />
                              <span>Piadinha LGBTQfóbica</span>
                            </label>
                          </p>
                        </div>


                        <div class="col s12">
                          <br><br>
                          <p>
                            <label>
                              <input type="checkbox" onclick="document.getElementById('desFieldNegativo').style.display = 'inline'" />
                              <span>Desejo descrever mais</span>
                            </label>
                          </p>
                          <br>
                        </div>

                        <div id="desFieldNegativo" class="col s12" style="display: none;">
                          <div class="input-field">
                            <input id="descricaoNegativo" type="text" class="validate">
                            <label for="descricaoNegativo">Descrição</label>
                          </div>
                        </div>




                        <a class="waves-effect waves-light btn-large purple" style="width: 100%" onclick="document.getElementById('RelatoForm3').style.display = 'inline'">Continuar</a>
                        <br/><br/>

                  </div>
            </div>
          </form>
      </div>
    </div>
  </div>

   <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <div id="RelatoForm2Pos" style="display: none" class="row">
        <form class="col s12">
            <div class="card white" style="z-index: 1000">
                  <div class="card-content purple-text darken-2">

                        <h3>Nos conte mais sobre o que aconteceu</h3>

                        <div class="col m6 s12">
                          <p class="tooltipped" data-tooltip="Você e o seu parceiro se sentiram tratados da mesma forma que casais heterossexuais no mesmo recinto">
                            <label>
                              <input id="PositivoTratamentoIgualitario" type="checkbox" />
                              <span>Tratamento igualitário para casal LGBTQ</span>
                            </label>
                          </p>
                          <p class="tooltipped" data-tooltip="Cartazes, pôsteres, vídeos, propagandas, bandeiras, discursos">
                            <label>
                              <input id="PositivoApoioPublico" type="checkbox" />
                              <span>Manifestação pública de apoio à causa LGBTQ</span>
                            </label>
                          </p>
                          <p class="tooltipped" data-tooltip="I am a tooltip">
                            <label>
                              <input id="PositivoAcomodacaoInclusiva" type="checkbox" />
                              <span>Acomodação inclusiva para pessoas trans</span>
                            </label>
                          </p>
                          <p class="tooltipped" data-tooltip="Eventos organizados em prol da causa LGBTQ+">
                            <label>
                              <input id="PositivoEventosLGBTQ" type="checkbox" />
                              <span>Organizar eventos pro LGBTQ</span>
                            </label>
                          </p>
                        </div>
                        <div class="col m6 s12">
                          <p class="tooltipped" data-tooltip="Tratamentos no local foram feitos de acordo com o gênero o qual a pessoa trans se identifica">
                            <label>
                              <input id="PositivoRespeitoTrans" type="checkbox" />
                              <span>Respeito à permanência da pessoa trans em local designado ao gênero com o qual se identifica</span>
                            </label>
                          </p>
                          <p class="tooltipped" data-tooltip="Em caso de ocorrências lgbtfobicas no local houve manifestação pública contra o ato">
                            <label>
                              <input id="PositivoRepudioLGBTfobia" type="checkbox" />
                              <span>Manifestação publica de repudio a atitude LGBTfobica</span>
                            </label>
                          </p>
                          <p class="tooltipped" data-tooltip="Proativamente se dispor a educar os demais sobre os problemas causados pela LGBTfobia">
                            <label>
                              <input id="PositivoVisibilidadeLGBTfobia" type="checkbox" />
                              <span>Levantar visibilidade sobre a questão da LGBTfobia</span>
                            </label>
                          </p>
                        </div>


                        <div class="col s12">
                          <br><br>
                          <p>
                            <label>
                              <input type="checkbox" onclick="document.getElementById('desFieldPositivo').style.display = 'inline'" />
                              <span>Desejo descrever mais</span>
                            </label>
                          </p>
                          <br>
                        </div>

                        <div id="desFieldPositivo" class="col s12" style="display: none;">
                          <div class="input-field">
                            <input id="descricaoPositiva" type="text" class="validate">
                            <label for="descricaoPositiva">Descrição</label>
                          </div>
                        </div>




                        <a class="waves-effect waves-light btn-large purple" style="width: 100%" onclick="document.getElementById('RelatoForm3').style.display = 'inline'">Continuar</a>
                        <br/><br/>

                  </div>
            </div>
          </form>
      </div>
    </div>
  </div>

  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <div id="RelatoForm3" style="display: none" class="row">
        <form class="col s12">
            <div class="card white" style="z-index: 1000">
                  <div class="card-content purple-text darken-2">

                        <h3>Onde foi?</h3>

                        <div class="col s12">
                          <div class="card white" style="z-index: 100;">
                                <div class="card-content purple-text darken-2">
                                  <input id="subpac-input" class="controls" type="text" placeholder="Procurar">
                                </div>
                              </div>
                          <div id="submap" class="card white" style="z-index: 100; min-height: 400px; height: 100%">
                                <div></div>
                          </div>
                        </div>

                        <div class="col s4" style="display: none">
                          <div class="input-field purple-text">
                            <select id="">
                              <option value="none">Não</option>
                              <option value="inline">Sim</option>
                            </select>
                            <label>Aconteceu em um estabelecimento?</label>
                          </div>
                        </div>

                        <div class="col s12" style="padding: 0px;">
                          <div class="col s4" style="display: none">
                            <div class="input-field purple-text">
                              <select id="">
                                <option value="none">Não</option>
                                <option value="inline">Sim</option>
                              </select>
                              <label>O estabelecimento se manifestou sobre o ocorrido?</label>
                            </div>
                          </div>
                          <div class="col s12">
                            <div class="col s12" >
                              <div class="input-field col s12">
                                <input id="EstabelecimentoInput" type="text" class="validate">
                                <label for="EstabelecimentoInput">Qual o estabelecimento?</label>
                              </div>
                            </div>
                          </div>
                        </div>

                        <a class="waves-effect waves-light btn-large purple" style="width: 100%" onclick="addRegistro();">Adicionar</a>
                        <br/><br/>

                  </div>
            </div>
          </form>
      </div>
    </div>
  </div>



  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <div class="row">
        <div class="col m4 s12">
            <div class="card white" style="z-index: 100">
                  <div class="card-content purple-text darken-2">
                    <h4 class="light">Novo relato</h4>

                        <a class="waves-effect waves-light btn-large purple" style="width: 100%" onclick="document.getElementById('RelatoForm1').style.display = 'inline'">Adicionar</a>
                  </div>
            </div>
            <div class="card white" style="z-index: 100; display: none">
                  <div class="card-content purple-text darken-2">
                        <div class="input-field purple-text">
                          <select id="SelectCases">
                            <option value="" selected>Todos</option>
                            <option value="Positivo">Positivos apenas</option>
                            <option value="Negativo">Negativos apenas</option>
                          </select>
                          <label>Mostrar</label>
                        </div>
                        <div class="input-field purple-text">
                          <select>
                            <option value="" selected>Todos</option>
                            <option value="2">Lésbicas</option>
                            <option value="2">Gays</option>
                            <option value="2">Bissexuais</option>
                            <option value="1">Trans</option>
                          </select>
                          <label>Publico</label>
                        </div>
                  </div>
            </div>
          </div>
          <div class="col m8 s12">
            <div class="card white" style="z-index: 100;">
                  <div class="card-content purple-text darken-2">
                    <input id="pac-input" class="controls" type="text" placeholder="Procurar">
                  </div>
                </div>
            <div id="map" class="card white" style="z-index: 100; min-height: 400px; height: 100%">
                  <div></div>
            </div>
          </div>
      </div>

    </div>
  </div>
</div>

<div class="section no-pad-bot" >
    <div class="container">
      <div id="RelatoDisplay" style="display: none;" class="row">
        <form class="col s12">
            <div class="card white" style="z-index: 1000">
                  <div class="card-content purple-text darken-2">
                    <div class="row">

                      <h3 id="DetalhesTitle" class="">Detalhes</h3>
                        <div class="row">
                          <div class="col m6 s12">
                            <div class="card purple" style="z-index: 100;">
                                  <div class="card-content white-text" id="GenderField" >

                                  </div>
                                </div>
                          </div>
                          <div class="col m6 s12">
                            <div id="RelatoCard" class="card red" style="z-index: 100;">
                                  <div class="card-content white-text"  id="RelatoField">

                                  </div>
                                </div>
                          </div>
                        </div>
                        <div class="col m6 s12">
                            <div id="IdadeField" class="col s12" style="">
                                <div class="input-field">
                                    <input disabled id="IdadeInput" type="text" class="validate">
                                </div>
                              </div>

                        </div>
                        <div class="col m6 s12">
                            <div id="LocalField" class="col s12" style="">
                                <div class="input-field">
                                    <input disabled id="LocalInput" type="text" class="validate">
                                </div>
                              </div>

                        </div>
                        <div class="col s12">
                          <div id="desFieldPositivo" class="col s12" style="">
                          <div class="input-field">
                              <textarea disabled id="DescricaoInput" class="materialize-textarea"></textarea>
                          </div>
                        </div>
                        </div>




                      </div>

                  </div>
            </div>
          </form>
      </div>
    </div>
  </div>

<div class="section no-pad-bot" id="index-banner" style="display: none">
    <div class="container">
      <div class="row">
        <div class="col s12">
            <div class="card white" style="z-index: 100">
                  <div class="card-content purple-text darken-2">
                      <h4 class="light">Kit primeiros socorros</h4>

                  </div>
            </div>
          </div>
      </div>

    </div>
  </div>

<!--
  <div class="fixed-action-btn">
  <a class="btn-floating btn-large purple">
    <i class="large material-icons">mode_edit</i>
  </a>
</div>-->

  <footer class="page-footer purple" >
    <div class="container">
      <div class="row"><!--
        <div class="col l6 s12">
          <h5 class="white-text">Contato</h5>
          <p class="grey-text text-lighten-4">GranFiber Telecom – Rua Vespasiano, 57 – N. Sra. das Graças. Santa Luzia – MG</p>
          <ul>
            <li><a class="white-text"><i class="material-icons">local_phone</i> (31) 4042-8111</a></li>
            <li><a class="white-text" href="mailto:contato@granfiber.com.br"><i class="material-icons">mail</i> contato@granfiber.com.br</a></li>
            <li><a class="white-text"><i class="material-icons">mode_comment</i> WhatsApp: (31) 985 452 915</a></li>
          </ul>

        </div>-->
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container" style ="display: none" >
      Made by <a class="purple-text text-lighten-3" href="https://alexwnukfilho.wordpress.com">Alexsandro Wnuk Filho</a>
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>


  <script>

  $(document).ready(function(){
    $('.datepicker').datepicker();
  });

  $(document).ready(function(){
    $('.fixed-action-btn').floatingActionButton();
    $('select').formSelect();
  });

  $(document).ready(function(){
    $('.tooltipped').tooltip();
  });

  $(document).ready(function(){
      var DBPositivo = firebase.database().ref('Positivo/');
      var DBNegativo = firebase.database().ref('Negativo/');
          $("#SelectCases").change(function(){
            deleteMarkers();
            switch($(this).children("option:selected").val()) {
                case 'Positivo':
                    PCases = {};
                    DBPositivo.once('value', function(snapshot) {
                        snapshot.forEach(function(childSnapshot) {
                          PCases = childSnapshot.val();
                          location = { lat: Number(PCases.lat) , lng:  Number(PCases.lng) };
                          addMarker(location, map , PurplePin);
                          npositivos++;
                        });
                        document.getElementById('npositivos').innerHTML = npositivos;
                      });
                    break;
                case 'Negativo':
                    PCases = {};
                    DBNegativo.once('value', function(snapshot) {
                      snapshot.forEach(function(childSnapshot) {
                        PCases = childSnapshot.val();
                        location = { lat: Number(PCases.lat) , lng:  Number(PCases.lng) };
                        addMarker(location, map , BlackPin);
                        nnegativos++;
                      });
                      document.getElementById('nnegativos').innerHTML = nnegativos;
                    });
                    break;
                default:
                    DBPositivo.once('value', function(snapshot) {
                        snapshot.forEach(function(childSnapshot) {
                          PCases = childSnapshot.val();
                          location = { lat: Number(PCases.lat) , lng:  Number(PCases.lng) };
                          addMarker(location, map , PurplePin);
                        });
                      });
                    DBNegativo.once('value', function(snapshot) {
                      snapshot.forEach(function(childSnapshot) {
                        PCases = childSnapshot.val();
                        location = { lat: Number(PCases.lat) , lng:  Number(PCases.lng) };
                        addMarker(location, map , BlackPin);
                      });
                    });
            }
          });
      });
  </script>


  </body>
</html>

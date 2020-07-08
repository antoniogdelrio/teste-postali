<?php
    define("INDEX_NOME", 0);
    define("INDEX_IDADE", 1);
    define("INDEX_SEXO", 2);
    define("INDEX_TURMA", 3);
    define("INDEX_PORTUGUES", 4);
    define("INDEX_MATEMATICA", 5);
    define("INDEX_GEOGRAFIA", 6);
    define("INDEX_BIMESTRE", 7);
    define("ALL_STUDENTS", 31);

    function convertStringToArray($str){
        $newArray = explode(";", $str);
        return $newArray;
    }
    function parseCSVArray ($line){
        $newLine = array_map('convertStringToArray', $line);
        return $newLine;
    }
 
    //Aluno com melhor média de notas em geral (todos os bimestres)
    function calculaMaiorMediaEmGeral($data){

        $medias = [];
        for($j=0; $j < ALL_STUDENTS ; $j++){
            $soma = 0;
            for($i=INDEX_PORTUGUES; $i <= INDEX_GEOGRAFIA ; $i++){
                $soma += (float)$data[$j][0][$i];
            }
            $media = $soma/3;
            array_push($medias, $media);
        }

        $maiorMedia = max($medias);
        $indexesMaiorNota = array_keys($medias, $maiorMedia);
        $nomesMaiorNota = [];

        for($j=0; $j < count($indexesMaiorNota) ; $j++){
            array_push( $nomesMaiorNota, $data[$indexesMaiorNota[$j]][0][0] );
        }
        return $nomesMaiorNota;
    }

    function calculaMenorMediaEmGeral($data){

        $medias = [];
        for($j=0; $j < ALL_STUDENTS ; $j++){
            $soma = 0;
            for($i=INDEX_PORTUGUES; $i <= INDEX_GEOGRAFIA ; $i++){
                $soma += (float)$data[$j][0][$i];
            }
            $media = $soma/3;
            array_push($medias, $media);
        }

        $menorMedia = min($medias);
        $indexesMenorNota = array_keys($medias, $menorMedia);
        $nomesMenorNota = [];

        for($j=0; $j < count($indexesMenorNota) ; $j++){
            array_push( $nomesMenorNota, $data[$indexesMenorNota[$j]][0][0] );
        }
        return $nomesMenorNota;
    }

    function retornaNotasPortugues($element){
        return $element[0][INDEX_PORTUGUES];
    }

    function retornaNotasMatematica($element){
        return $element[0][INDEX_MATEMATICA];
    }

    function retornaNotasGeografia($element){
        return $element[0][INDEX_GEOGRAFIA];
    }
    
    function retornaAlunosDestaquePorDisciplina($data){
        $notasPortugues = [];
        $notasMatematica = [];
        $notasGeografia = [];

        $notasPortugues = array_map('retornaNotasPortugues',$data);
        $notasMatematica = array_map('retornaNotasMatematica',$data);
        $notasGeografia = array_map('retornaNotasGeografia',$data);

        $maiorNotaPortugues = max($notasPortugues);
        $maiorNotaMatematica = max($notasMatematica);
        $maiorNotaGeografia = max($notasGeografia);

        $indexesMaiorNotaPortugues = array_keys($notasPortugues, $maiorNotaPortugues);
        $indexesMaiorNotaMatematica = array_keys($notasMatematica, $maiorNotaMatematica);
        $indexesMaiorNotaGeografia = array_keys($notasGeografia, $maiorNotaGeografia);

        $alunosDestaquePortugues = [];
        $alunosDestaqueMatematica = [];
        $alunosDestaqueGeografia = [];

        for($i=0 ; $i < count($indexesMaiorNotaPortugues) ; $i++){
            $info = ["nome" => $data[$indexesMaiorNotaPortugues[$i]][0][0], "nota" => $maiorNotaPortugues];
            array_push($alunosDestaquePortugues, $info);
        }

        for($i=0 ; $i < count($indexesMaiorNotaMatematica) ; $i++){
            $info = ["nome" => $data[$indexesMaiorNotaMatematica[$i]][0][0], "nota" => $maiorNotaMatematica];
            array_push($alunosDestaqueMatematica, $info);
        }

        for($i=0 ; $i < count($indexesMaiorNotaGeografia) ; $i++){
            $info = ["nome" => $data[$indexesMaiorNotaGeografia[$i]][0][0], "nota" => $maiorNotaGeografia];
            array_push($alunosDestaqueGeografia, $info);
        }

        $alunosDestaquePorDisciplina = ["portugues" => $alunosDestaquePortugues, "matematica" => $alunosDestaqueMatematica, "geografia"=>$alunosDestaqueGeografia];
        
        return $alunosDestaquePorDisciplina;
    }

    function retornaAlunoComMaiorPorcentagemDeMelhora($data){
        $mediasPrimeiroBimestre = [];
        $mediasSegundoBimestre = [];

        for($j=0; $j < ALL_STUDENTS ; $j++){
            $soma = 0;
            for($i=INDEX_PORTUGUES; $i <= INDEX_GEOGRAFIA ; $i++){
                $soma += (float)$data[$j][0][$i];
            }
            $media = $soma/3;
            if((int)$data[$j][0][INDEX_BIMESTRE] == 1){
                $info = ["nome" => $data[$j][0][0], "media" => $media];
                array_push($mediasPrimeiroBimestre, $info);
            }
            else if((int)$data[$j][0][INDEX_BIMESTRE] == 2){
                $info = ["nome" => $data[$j][0][0], "media" => $media];
                array_push($mediasSegundoBimestre, $info);
            }
        }

        $variacaoEmPorcentagem = [];
        $variacaoEmPorcentagemComNome = [];

        $contadorArrayVariacaoEmPorcentagem = 0;
        for($j=0; $j < count($mediasPrimeiroBimestre); $j++){
            for($i=0; $i < count($mediasSegundoBimestre) ; $i++){
                if($mediasPrimeiroBimestre[$j]["nome"] == $mediasSegundoBimestre[$i]["nome"]){
                    $variacaoEmPorcentagem[$contadorArrayVariacaoEmPorcentagem] = (float)(((float)$mediasSegundoBimestre[$i]["media"] - (float)$mediasPrimeiroBimestre[$j]["media"])/((float)$mediasPrimeiroBimestre[$j]["media"]))*(100);

                    $variacaoEmPorcentagemComNome[$contadorArrayVariacaoEmPorcentagem] = ["nome" => $mediasPrimeiroBimestre[$j]["nome"], "variacao" => $variacaoEmPorcentagem[$contadorArrayVariacaoEmPorcentagem]];
                    $contadorArrayVariacaoEmPorcentagem++;
                    break;
                }
            }
        }

        $melhoraMaisSignificativa = max($variacaoEmPorcentagem);
        $indexesDasMelhoras = array_keys($variacaoEmPorcentagem, $melhoraMaisSignificativa);
        $alunosComMaioresMelhoras = [];

        for($j = 0; $j < count($indexesDasMelhoras) ; $j++){
            array_push($alunosComMaioresMelhoras, $variacaoEmPorcentagemComNome[$indexesDasMelhoras[$j]]);
        }

        return $alunosComMaioresMelhoras;
    }

    function retornaAlunoComMaiorPorcentagemDePiora($data){
        $mediasPrimeiroBimestre = [];
        $mediasSegundoBimestre = [];

        for($j=0; $j < ALL_STUDENTS ; $j++){
            $soma = 0;
            for($i=INDEX_PORTUGUES; $i <= INDEX_GEOGRAFIA ; $i++){
                $soma += (float)$data[$j][0][$i];
            }
            $media = $soma/3;
            if((int)$data[$j][0][INDEX_BIMESTRE] == 1){
                $info = ["nome" => $data[$j][0][0], "media" => $media];
                array_push($mediasPrimeiroBimestre, $info);
            }
            else if((int)$data[$j][0][INDEX_BIMESTRE] == 2){
                $info = ["nome" => $data[$j][0][0], "media" => $media];
                array_push($mediasSegundoBimestre, $info);
            }
        }

        $variacaoEmPorcentagem = [];
        $variacaoEmPorcentagemComNome = [];

        $contadorArrayVariacaoEmPorcentagem = 0;
        for($j=0; $j < count($mediasPrimeiroBimestre); $j++){
            for($i=0; $i < count($mediasSegundoBimestre) ; $i++){
                if($mediasPrimeiroBimestre[$j]["nome"] == $mediasSegundoBimestre[$i]["nome"]){
                    $variacaoEmPorcentagem[$contadorArrayVariacaoEmPorcentagem] = (float)(((float)$mediasSegundoBimestre[$i]["media"] - (float)$mediasPrimeiroBimestre[$j]["media"])/((float)$mediasPrimeiroBimestre[$j]["media"]))*(100);

                    $variacaoEmPorcentagemComNome[$contadorArrayVariacaoEmPorcentagem] = ["nome" => $mediasPrimeiroBimestre[$j]["nome"], "variacao" => $variacaoEmPorcentagem[$contadorArrayVariacaoEmPorcentagem]];
                    $contadorArrayVariacaoEmPorcentagem++;
                    break;
                }
            }
        }

        $pioraMaisSignificativa = min($variacaoEmPorcentagem);
        $indexesDasPioras = array_keys($variacaoEmPorcentagem, $pioraMaisSignificativa);
        print_r($indexesDasPioras);
        $alunosComMaioresPioras = [];

        for($j = 0; $j < count($indexesDasPioras) ; $j++){
            array_push($alunosComMaioresPioras, $variacaoEmPorcentagemComNome[$indexesDasPioras[$j]]);
        }
        
        return $alunosComMaioresPioras;
    }

    function retornaMateriasComMaioresNotasNoGeral($data){
        $notasPortugues = [];
        $notasMatematica = [];
        $notasGeografia = [];

        $notasPortugues = array_map('retornaNotasPortugues',$data);
        $notasMatematica = array_map('retornaNotasMatematica',$data);
        $notasGeografia = array_map('retornaNotasGeografia',$data);

        $mediaPortugues;
        $mediaMatematica;
        $mediaGeografia;

        for($j=0; $j < count($notasPortugues) ; $j++){
            $mediaPortugues += (float)$notasPortugues[$j];
        }
        $mediaPortugues = $mediaPortugues/(count($notasPortugues));

        for($j=0; $j < count($notasMatematica) ; $j++){
            $mediaMatematica += (float)$notasMatematica[$j];
        }
        $mediaMatematica = $mediaMatematica/(count($notasMatematica));

        for($j=0; $j < count($notasGeografia) ; $j++){
            $mediaGeografia += (float)$notasGeografia[$j];
        }
        $mediaGeografia = $mediaGeografia/(count($notasGeografia));

        $mediasPorDisciplina = ["portugues" => $mediaPortugues, "matematica" => $mediaMatematica, "geografia" => $mediaGeografia];

        $maiorMedia = max($mediasPorDisciplina);
        $disciplinaComMaiorMedia = array_keys($mediasPorDisciplina, $maiorMedia)[0];

        return ["disciplina" => $disciplinaComMaiorMedia, "media" => $maiorMedia];
    }

    function retornaMateriasComMenoresNotasNoGeral($data){
        $notasPortugues = [];
        $notasMatematica = [];
        $notasGeografia = [];

        $notasPortugues = array_map('retornaNotasPortugues',$data);
        $notasMatematica = array_map('retornaNotasMatematica',$data);
        $notasGeografia = array_map('retornaNotasGeografia',$data);

        $mediaPortugues;
        $mediaMatematica;
        $mediaGeografia;

        for($j=0; $j < count($notasPortugues) ; $j++){
            $mediaPortugues += (float)$notasPortugues[$j];
        }
        $mediaPortugues = $mediaPortugues/(count($notasPortugues));

        for($j=0; $j < count($notasMatematica) ; $j++){
            $mediaMatematica += (float)$notasMatematica[$j];
        }
        $mediaMatematica = $mediaMatematica/(count($notasMatematica));

        for($j=0; $j < count($notasGeografia) ; $j++){
            $mediaGeografia += (float)$notasGeografia[$j];
        }
        $mediaGeografia = $mediaGeografia/(count($notasGeografia));

        $mediasPorDisciplina = ["portugues" => $mediaPortugues, "matematica" => $mediaMatematica, "geografia" => $mediaGeografia];

        $menorMedia = min($mediasPorDisciplina);
        $disciplinaComMenorMedia = array_keys($mediasPorDisciplina, $menorMedia)[0];

        return ["disciplina" => $disciplinaComMenorMedia, "media" => $menorMedia];
    }

    function retornaTurmasComMelhoresNotasPorDisciplina($data){
        $mediasTurmaA = [];
        $mediasTurmaB = [];

        for($j=0; $j < ALL_STUDENTS ; $j++){
            $info = ["portugues" => (float)$data[$j][0][INDEX_PORTUGUES], "matematica" => (float)$data[$j][0][INDEX_MATEMATICA], "geografia" => (float)$data[$j][0][INDEX_GEOGRAFIA]];
            if($data[$j][0][INDEX_TURMA] == "A"){
                array_push($mediasTurmaA, $info);
            }
            else if($data[$j][0][INDEX_TURMA] == "B"){
                array_push($mediasTurmaB, $info);
            }
        }

        $mediasTurmaAporDisciplina = ["portugues" => 0, "matematica" => 0, "geografia" => 0];
        $mediasTurmaBporDisciplina = ["portugues" => 0, "matematica" => 0, "geografia" => 0];

        for($i=0; $i < count($mediasTurmaA); $i++){
            $notaPortugues = $mediasTurmaA[$i]["portugues"];
            $notaMatematica = $mediasTurmaA[$i]["matematica"];
            $notaGeografia = $mediasTurmaA[$i]["geografia"];

            $mediasTurmaAporDisciplina["portugues"] += $notaPortugues;
            $mediasTurmaAporDisciplina["matematica"] += $notaMatematica;
            $mediasTurmaAporDisciplina["geografia"] += $notaGeografia;
        }

        $mediasTurmaAporDisciplina["portugues"] /= count($mediasTurmaA);
        $mediasTurmaAporDisciplina["matematica"] /= count($mediasTurmaA);
        $mediasTurmaAporDisciplina["geografia"] /= count($mediasTurmaA);

        for($i=0; $i < count($mediasTurmaB); $i++){
            $notaPortugues = $mediasTurmaB[$i]["portugues"];
            $notaMatematica = $mediasTurmaB[$i]["matematica"];
            $notaGeografia = $mediasTurmaB[$i]["geografia"];

            $mediasTurmaBporDisciplina["portugues"] += $notaPortugues;
            $mediasTurmaBporDisciplina["matematica"] += $notaMatematica;
            $mediasTurmaBporDisciplina["geografia"] += $notaGeografia;
        }

        $mediasTurmaBporDisciplina["portugues"] /= count($mediasTurmaA);
        $mediasTurmaBporDisciplina["matematica"] /= count($mediasTurmaA);
        $mediasTurmaBporDisciplina["geografia"] /= count($mediasTurmaA);

        $melhoresTurmasPorDisciplina = ["portugues" => "", "matematica" => "", "geografia" => ""];

        if($mediasTurmaAporDisciplina["portugues"] > $mediasTurmaBporDisciplina["portugues"]){
            $melhoresTurmasPorDisciplina["portugues"] = "A";
        }
        else{
            $melhoresTurmasPorDisciplina["portugues"] = "B";
        }
        if($mediasTurmaAporDisciplina["matematica"] > $mediasTurmaBporDisciplina["matematica"]){
            $melhoresTurmasPorDisciplina["matematica"] = "A";
        }
        else{
            $melhoresTurmasPorDisciplina["matematica"] = "B";
        }
        if($mediasTurmaAporDisciplina["geografia"] > $mediasTurmaBporDisciplina["geografia"]){
            $melhoresTurmasPorDisciplina["geografia"] = "A";
        }
        else{
            $melhoresTurmasPorDisciplina["geografia"] = "B";
        }

        return $melhoresTurmasPorDisciplina;
    }

    function retornaBimestreComMelhoresNotasParaCadaDisciplina($data){
        $mediasPrimeiroBimestre = [];
        $mediasSegundoBimestre = [];

        for($j=0; $j < ALL_STUDENTS ; $j++){
            $info = ["portugues" => (float)$data[$j][0][INDEX_PORTUGUES], "matematica" => (float)$data[$j][0][INDEX_MATEMATICA], "geografia" => (float)$data[$j][0][INDEX_GEOGRAFIA]];
            if((int)$data[$j][0][INDEX_BIMESTRE] == 1){
                array_push($mediasPrimeiroBimestre, $info);
            }
            else if((int)$data[$j][0][INDEX_BIMESTRE] == 2){
                array_push($mediasSegundoBimestre, $info);
            }
        }

        $mediasPrimeiroBimestreporDisciplina = ["portugues" => 0, "matematica" => 0, "geografia" => 0];
        $mediasSegundoBimestreporDisciplina = ["portugues" => 0, "matematica" => 0, "geografia" => 0];

        for($i=0; $i < count($mediasPrimeiroBimestre); $i++){
            $notaPortugues = $mediasPrimeiroBimestre[$i]["portugues"];
            $notaMatematica = $mediasPrimeiroBimestre[$i]["matematica"];
            $notaGeografia = $mediasPrimeiroBimestre[$i]["geografia"];

            $mediasPrimeiroBimestreporDisciplina["portugues"] += $notaPortugues;
            $mediasPrimeiroBimestreporDisciplina["matematica"] += $notaMatematica;
            $mediasPrimeiroBimestreporDisciplina["geografia"] += $notaGeografia;
        }

        $mediasPrimeiroBimestreporDisciplina["portugues"] /= count($mediasPrimeiroBimestre);
        $mediasPrimeiroBimestreporDisciplina["matematica"] /= count($mediasPrimeiroBimestre);
        $mediasPrimeiroBimestreporDisciplina["geografia"] /= count($mediasPrimeiroBimestre);

        for($i=0; $i < count($mediasSegundoBimestre); $i++){
            $notaPortugues = $mediasSegundoBimestre[$i]["portugues"];
            $notaMatematica = $mediasSegundoBimestre[$i]["matematica"];
            $notaGeografia = $mediasSegundoBimestre[$i]["geografia"];

            $mediasSegundoBimestreporDisciplina["portugues"] += $notaPortugues;
            $mediasSegundoBimestreporDisciplina["matematica"] += $notaMatematica;
            $mediasSegundoBimestreporDisciplina["geografia"] += $notaGeografia;
        }

        $mediasSegundoBimestreporDisciplina["portugues"] /= count($mediasSegundoBimestre);
        $mediasSegundoBimestreporDisciplina["matematica"] /= count($mediasSegundoBimestre);
        $mediasSegundoBimestreporDisciplina["geografia"] /= count($mediasSegundoBimestre);

        $melhoresBimestresPorDisciplina = ["portugues" => 0, "matematica" => 0, "geografia" => 0];

        if($mediasPrimeiroBimestreporDisciplina["portugues"] > $mediasSegundoBimestreporDisciplina["portugues"]){
            $melhoresBimestresPorDisciplina["portugues"] = 1;
        }
        else{
            $melhoresBimestresPorDisciplina["portugues"] = 2;
        }
        if($mediasPrimeiroBimestreporDisciplina["matematica"] > $mediasSegundoBimestreporDisciplina["matematica"]){
            $melhoresBimestresPorDisciplina["matematica"] = 1;
        }
        else{
            $melhoresBimestresPorDisciplina["matematica"] = 2;
        }
        if($mediasPrimeiroBimestreporDisciplina["geografia"] > $mediasSegundoBimestreporDisciplina["geografia"]){
            $melhoresBimestresPorDisciplina["geografia"] = 1;
        }
        else{
            $melhoresBimestresPorDisciplina["geografia"] = 2;
        }

        echo "thunder";
        print_r($melhoresBimestresPorDisciplina);
        return $melhoresBimestresPorDisciplina;
    }

    $tmpFile = $_FILES['file']['tmp_name'];
    $csvAsArray = array_map('str_getcsv', file($tmpFile));
    $csvAsArrayParsed = array_map('parseCSVArray', $csvAsArray);
    array_shift($csvAsArrayParsed);

    $melhoresMediasEmGeral = calculaMaiorMediaEmGeral($csvAsArrayParsed);
    $pioresMediasEmGeral = calculaMenorMediaEmGeral($csvAsArrayParsed);
    $alunosDestaqueDisciplina = retornaAlunosDestaquePorDisciplina($csvAsArrayParsed);
    print_r($alunosDestaqueDisciplina);
?> 

<div>

    <p>Quais os alunos com a melhores média de notas em geral? (todos os bimestres)</p>
    <?php
        foreach ($melhoresMediasEmGeral as $aluno) {
            echo "<h4>\n";
            echo $aluno;
            echo "</h4>";
        }
    ?>

    <p>Qual o aluno com a pior média de notas em geral (todos os bimestres).</p>
        <?php
            foreach ($pioresMediasEmGeral as $aluno) {
                echo "<h4>\n";
                echo $aluno;
                echo "</h4>";
            }
        ?>
    <p>Quais os alunos destaque (melhores notas) de cada disciplina em todos os bimestres.</p>
        <?php
            echo "<h4> Em português\n";
            echo $alunosDestaqueDisciplina["portugues"];
            echo "</h4>";
            echo "<h4> Em Matemática\n";
            echo $$alunosDestaqueDisciplina["matematica"];
            echo "</h4>";
            echo "<h4> Em Geografia\n";
            echo $$alunosDestaqueDisciplina["geografia"];
            echo "</h4>";
        
        ?>
    <p>Qual aluno possui a melhora mais significativa no último bimestre com relação ao primeiro
bimestre.</p>

    <p>Qual aluno possui a piora mais significativa no último bimestre com relação ao primeiro
bimestre.</p>

    <p>Qual a matéria cujas notas foram maiores em geral (todos os bimestres).</p>

    <p>Qual a matéria cujas notas foram menores em geral (todos os bimestres).</p>

    <p>Qual turma tem as melhores notas em cada disciplina: Português, Matemática e Geografia
em geral (todos os bimestres).</p>

    <p>Em qual bimestre houveram as melhores notas em cada disciplina: Português,
Matemática e Geografia em geral (todos os bimestres). </p>

</div>
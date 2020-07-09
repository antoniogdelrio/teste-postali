<?php
    require_once('actions.php')
?> 

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles/results.css">
    <title>CSV Reader</title>
</head>
<body>
    <h1>Teste Postali</h1>
    <div class="results">
        <div class="question">
            <h4>Quais os alunos com a melhores média de notas em geral? (todos os bimestres)</h4>
            <?php
                foreach ($melhoresMediasEmGeral as $aluno) {
                    echo "<p>\n";
                    echo $aluno;
                    echo "</p>";
                }
            ?>
        </div>
        
        <div class="question">
            <h4>Qual o aluno com a pior média de notas em geral (todos os bimestres).</h4>
                <?php
                    foreach ($pioresMediasEmGeral as $aluno) {
                        echo "<p>\n";
                        echo $aluno;
                        echo "</p>";
                    }
                ?>
        </div>

        <div class="question">
            <h4>Quais os alunos destaque (melhores notas) de cada disciplina em todos os bimestres.</h4>
                <?php 
                    echo "<h4> Em português\n </h4>";
                    foreach ($alunosDestaqueDisciplina["portugues"] as $aluno){
                        echo "<p><strong>Aluno(a)</strong>: " . $aluno["nome"] . ", " . "com média " . $aluno["nota"];
                        echo "<p/>";
                    }
                    echo "<h4> Em matemática\n </h4>";
                    foreach ($alunosDestaqueDisciplina["matematica"] as $aluno){
                        echo "<p><strong>Aluno(a)</strong>: " . $aluno["nome"] . ", " . "com média " . $aluno["nota"];
                        echo "<p/>";
                    }
                    echo "<h4> Em geografia\n </h4>";
                    foreach ($alunosDestaqueDisciplina["geografia"] as $aluno){
                        echo "<p><strong>Aluno(a)</strong>: " . $aluno["nome"] . ", " . "com média " . $aluno["nota"];
                        echo "<p/>";
                    }
                ?>
        </div>

        <div class="question">
            <h4>Qual aluno possui a melhora mais significativa no último bimestre com relação ao primeiro
                bimestre.</h4>
            <?php 
                    foreach($alunosMaioresMelhoras as $aluno){
                        echo "<p><strong>Aluno(a)</strong>: " . $aluno["nome"] . " com melhora de " . $aluno["variacao"] . "%";
                        echo "<p/>";
                    }
            ?>
        </div>

        <div class="question">
            <h4>Qual aluno possui a piora mais significativa no último bimestre com relação ao primeiro
                bimestre.</h4>
            <?php 
                    foreach($alunosMaioresPioras as $aluno){
                        echo "<p><strong>Aluno(a)</strong>: " . $aluno["nome"] . " com piora de " . $aluno["variacao"] . "%";
                        echo "<p/>";
                    }
            ?>
        </div>
        
        <div class="question">
            <h4>Qual a matéria cujas notas foram maiores em geral (todos os bimestres).</h4>
            <?php
                echo "<p>A matéria com maior nota foi " . $materiasMaiorNotaEmGeral["disciplina"] . ", com média de " . $materiasMaiorNotaEmGeral["media"]; 
            ?>
        </div>

        <div class="question">
            <h4>Qual a matéria cujas notas foram menores em geral (todos os bimestres).</h4>
            <?php
                echo "<p>A matéria com menor nota foi " . $materiasMenorNotaEmGeral["disciplina"] . ", com média de " . $materiasMenorNotaEmGeral["media"]; 
            ?>
        </div>

        <div class="question">
            <h4>Qual turma tem as melhores notas em cada disciplina: Português, Matemática e Geografia
            em geral (todos os bimestres).</h4>
            <?php 
                    echo "<h4> Em português\n </h4>";
                    echo "<p>A melhor nota foi da turma " . $turmasComMelhoresNotasPorDisciplina["portugues"];
                    echo "<p/>";
                    echo "<h4> Em matemática\n </h4>";
                    echo "<p>A melhor nota foi da turma " . $turmasComMelhoresNotasPorDisciplina["matematica"];
                    echo "<p/>";
                    echo "<h4> Em geografia\n </h4>";
                    echo "<p>A melhor nota foi da turma " . $turmasComMelhoresNotasPorDisciplina["geografia"];
                    echo "<p/>"

            ?>
        </div>

        <div class="question">
            <h4>Em qual bimestre houveram as melhores notas em cada disciplina: Português,
            Matemática e Geografia em geral (todos os bimestres). </h4>
            <?php 
                    echo "<h4> Em português\n </h4>";
                    echo "<p>As maiores notas foram no " . $bimestreComMelhoresNotasPorDisciplina["portugues"] . 'º bimestre.';
                    echo "<p/>";
                    echo "<h4> Em matemática\n </h4>";
                    echo "<p>As maiores notas foram no " . $bimestreComMelhoresNotasPorDisciplina["matematica"] . 'º bimestre.';            echo "<p/>";
                    echo "<h4> Em geografia\n </h4>";
                    echo "<p>As maiores notas foram no " . $bimestreComMelhoresNotasPorDisciplina["geografia"] . 'º bimestre.';            echo "<p/>"
            ?>
        </div>

    </div>
</body>
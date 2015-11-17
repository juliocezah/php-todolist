<?php

class TaskService{
    
    public static function listTasks(){
        $db = ConnectionFactory::getDB(); //Classe que pega a conexão com o Banco de Dados
        $tasks = array(); //$tasks = uma caixa, 'vetor', vazio
        
        foreach($db->tasks() as $task){  //O tasks (depois do '$db->') é o nome da TABELA em schema.sql | Para cada registro da tabela, colocar dentro do $tasks (vetor)
            $tasks[] = array (
                'id' => $task['id'],
                'description' => $task['description'],
                'done' => $task['done']
            );
        }
        
        $tasks;
    }
}
?>
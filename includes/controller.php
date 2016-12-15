<?php
/**
 * Created by IntelliJ IDEA.
 * User: mcardenas
 * Date: 15/06/16
 * Time: 2:12
 */

require_once dirname(__DIR__).'/model/Project.php';

function getListProject(){
    $project = new Project();
    return $project->getAll();
}
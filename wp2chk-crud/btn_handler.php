<?php


require_once 'CartButton.php';

// get will be true if u only check isset($_GET)
// Don't know what is the problem so use isset($_GET['action'])
if(isset($_GET['action']))
{
    if($_GET['action'] == 'edit')
    {
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $btn = new CartButton();
            $response = $btn->edit($id);
            echo json_encode($response);
        }
    }
    elseif($_GET['action'] == 'delete')
    {
        if(!is_array($_GET['ids'])){
            $id = $_GET['ids'];
            $btn = new CartButton();
            $response = $btn->delete($id);
            session_regenerate_id(true);
            header('Location: '.$response["redirectUrl"].'');
            session_write_close();
            exit;
        }
        else{
            $id = $_GET['ids'];
            $btn = new CartButton();
            $response = $btn->delete($id);
            echo json_encode($response);
            exit;
        }

    }
}
elseif(isset($_POST['preview']) && $_POST['preview']){
    $btn = new CartButton();
    $response = $btn->wp2chkPreview($_POST);
    echo json_encode($response);
}
elseif(isset($_POST['action']))
{
    if(isset($_POST['action']) && $_POST['action'] == "Add" )
    {   
        $btnData = new CartButton();
        $btnData->setData($_POST);
        $response = $btnData->save();
        echo json_encode($response);
    }

    if(isset($_POST['action']) && $_POST['action'] == "Update")
    {
        $id = $_POST['id'];
        $btnData = new CartButton();
        $btnData->setData($_POST);
        $response = $btnData->update($id);
        echo json_encode($response);
    }
}



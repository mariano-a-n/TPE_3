<?php

class GuardMiddleware
{
    public function run($request)
    {
        if ($request->user) {
            return $request;
        } else {
            header("Location: " . BASE_URL . "login");
            exit();
        }
    }
}

    // function GuardMiddleware($res) {
    //     if (isset ($_SESSION['id'])) {
    //         $res-> user = new StdClass;
    //         $res -> user -> usuario = ($_SESSION['id']);
    //         return;
    //     }
    // }
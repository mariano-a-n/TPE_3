<?php

    class SessionMiddleware {

        public function run($request){
            if(isset($_SESSION['USER_ID'])){
                $request->user = new StdClass();
                $request->user->id = $_SESSION['USER_ID'];
                $request->user->email = $_SESSION['USER_EMAIL'];   
            } else {
                $request->user = null;
            }
            return $request;
        }

    }
<!DOCTYPE html>
<html lang=en>
    <head>
        <title>Table-Based Layout with CSS</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">  
        <style type="text/css">
        * {box-sizing: border-box;}

        #header  {background-color: #488AC7;
                  padding: 20px;
                  text-align: center;
                  font-family: Georgia;
                  font-size: 30px;
                  color: white;
                  border-top: 3px solid #000;
                  border-bottom: 3px solid #000;
                  border-left: 3px solid #000;
                  border-right: 3px solid #000;
                  margin: auto auto 8px auto;}

        #footer  {background-color: #777;
                  padding: 10px;
                  text-align: center;
                  color: white;}

        ul  {width: auto;
             padding: 10px;
             background-color: #98AFC7;
             margin: auto auto auto auto;
             font-family: Georgia;
             border-top: 3px solid #000;
             border-bottom: 3px solid #000;
             border-left: 3px solid #000;
             border-right: 3px solid #000;
             text-align: center;}
        
        li  {display: inline;
             margin: 0px 4px;}
     
        a  {color: #000000;
            text-transform: uppercase;
            text-decoration: none;
            padding: 6px 18px 5px 18px;}

        a:hover, a.on  {color: #cc3333;
                        background-color: #ffffff;}

        p {float: left;
           width: 20%;
           height: auto;
           background: #ccc;
           padding: 20px;
           margin-right: 10px;}
        
        article {float: center;
                 padding: 20px;
                 width: auto;
                 background-color: #B9D9EB;
                 height: auto;
                 margin-top: 15px;}
        
        #main:after  {content: "";
                      display: table;
                      clear: both;}

        #content {width: 100%;}
        
        </style>
    </head>
        <body>          
            <div id=page>
                <div id="header">
                    <h1 id="top">Financing for Dummies</h1>
                </div>
                <ul id="navigation">
                    <li><a href="#top">Home</a></li>
                    <li><a href="">Accounts</a></li>
                    <li><a href="">Budgeting</a></li>
                    <li><a href="">New Transaction</a></li>
                    <li><a href="">Settings</a></li>
                </ul>
                <div id="main">
                    <article>
                    </article>
                </div>               
            </div>           
        </body>   
</html>
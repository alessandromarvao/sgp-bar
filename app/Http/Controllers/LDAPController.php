<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LDAPController extends Controller
{
    private $conn;
    private $ldapBlind;

    function __construct()
    {
        $this->conn = \ldap_connect(env('LDAP_SERVER'), env('LDAP_PORT')) or die ("Sem conexão com o servidor de domínio");
    }

    function __destruct()
    {
        $this->conn = null;
        $this->ldapBlind = null;
    }

    /**
     * Redireciona à página de login. Se houve tentativa de login sem sucesso, aparecerá a mensagem da variável $msg
     * 
     * @param Request $request
     */
    public function checkLogin(Request $request)
    {
        if(isset($request->msg)){
            return view('login')->with('msg','Usuário ou senha incorretos!');
        } else {
            return view('login');
        }
    }

    public function checkAccess(Request $request)
    {
        // using ldap bind
        $ldaprdn  = $request->usr . "@". env('LDAP_DOMAIN');     // ldap rdn or dn
        $ldappass = $request->pwd;  // associated password
        
        // connect to ldap server
        if ($this->conn) {
            // binding to ldap server
            $this->ldapBind = @ldap_bind($this->conn, $ldaprdn, $ldappass);
            
            // verify binding
            if ($this->ldapBind) {
                $json = $this->search($request->usr);
                // return $json;
                return view('user.index')->with('usr', $json);
            } else {
                // return view('login')->with('msg','Usuário ou senha incorreto!');
                return redirect()->route('index', ['msg' => 'erro']);
            }
        }
    }

    /**
     * Pesquisa os dados do usuário no domínio
     * 
     * @param $usr Credencial do usuário
     * @return array Dados do usuário selecionado
     */
    private function search(String $user)
    {
        $base_dn = "OU=ifma,DC=ifma,DC=edu";
        // $filter = "(&(objectClass=user))";
        $filter = "(&(samaccountname=" . $user . "))";
        if($search=ldap_search($this->conn, $base_dn, $filter))
        {
            $number_returned = ldap_count_entries($this->conn, $search);
            $info = ldap_get_entries($this->conn, $search);
            // echo substr($info[0]['extensionattribute7'][0], 0, -4) . "-" . substr($info[0]['extensionattribute7'][0], 4, 2) . "-" . substr($info[0]['extensionattribute7'][0],6,2); //data de nascimento
            // echo $info[0]['extensionattribute6'][0]; //cpf
            // echo $info[0]['mail'][0]; //email
            // echo $info[0]['cn'][0]; //matrícula
            // echo $info[0]['description'][0]; // Nome completo

            $array = [
                'usr' => $user,
                'cpf' => $info[0]['extensionattribute6'][0],
                'nome' => $info[0]['description'][0],
                'email' => $info[0]['mail'][0],
                'data_nascimento' => substr($info[0]['extensionattribute7'][0], 0, -4) . "-" . substr($info[0]['extensionattribute7'][0], 4, 2) . "-" . substr($info[0]['extensionattribute7'][0],6,2),
            ];

            return response()->json($array);
        } else 
        {
            return null;
        }
    }
}

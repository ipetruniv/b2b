<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Validator;
use DB;
use Illuminate\Support\Facades\Hash;


class ApiUser extends Controller
{
  
    /**
     * Список несинхронізованих користувачів
     * @return xml
     */
    public function getUserAction()
    {
        $users = DB::table('users')->where('is_admin','=',0)->get()->toArray();
//        $users = DB::table('users')->where('user_is_synk', '=', 0)->get()->toArray();
        $xml_users = new \SimpleXMLElement( "<?xml version=\"1.0\"?><users></users>" );
        if (count($users)>0 ) {          
            $country   = '';
            $sity      = '';
            $region    = '';
            $build     = '';
            $street    = '';
            $province  = '';
            $post_code = '';
            
            $post_country   = '';
            $post_region    = '';
            $post_city      = '';
            $post_street    = '';
            $post_post_code = '';
            $post_post_province = '';

            
            foreach ( $users as $row )
            {
              if($row->country) {
                $country = $row->country .',';
              } 
              if($row->city) {
                $sity = $row->city .',';
              } 
              if($row->province) {
                $province = $row->province .',';
              } 
              if($row->region) {
                $region = $row->region .',';
              } 
              if($row->street) {
                $street = $row->street .',';
              }
              if($row->build) {
                $build = $row->build .',';
              }
              
              if($row->post_country) {
                $post_country = $row->post_country .',';
              } 
              if($row->post_region) {
                  $post_region = $row->post_region .',';
              } 
              if($row->post_city) {
                  $post_city = $row->post_city .',';
              } 
              if($row->post_street) {
                  $post_street = $row->post_street .',';
              }
              if($row->post_post_code) {
                  $post_post_code = $row->post_post_code .',';
              }
              if($row->post_province) {
                  $post_post_province  = $row->post_province .',';
              }
              
              // $address_user =  $country.$province.$sity.$region.$street.$build.$post_code;
                         
              $address_poss = $post_country.$post_post_province.$post_region.$post_city.$post_street.$post_post_code;
              
              
              $this -> prepareXml( [ 'data' => [
                  'web_id'       => $row->id,
                  'code_1c'      => $row->user_code_1c,
                  'name'         => $row->name,
                  'agent_id'     => $row->agent_id,
                  'diller_id'    => $row->diller_id, 
                  'type_price'   => $row->type_price, 
                  'name'         => $row->name,
                  'email'        => $row->email,
                  'surname'      => $row->surname,
                  'company'      => $row->company,
                  'vat'          => $row->vat,
                  'is_legal'     => $row->is_legal,
                  'phone'        => $row->phone,
                  'phone_company'=> $row->phone_company,
                  'cf'           => $row->cf,
                  'address_user'      => $row->country.','.$row->province.','.$row->city.','.$row->region.','.$row->street.','.$row->build.','.$row->post_code,
                  'address_user_pos'  => $row->post_country.','.$row->post_province.','.$row->post_region.','.$row->post_city.','.$row->post_street.','.$row->post_post_code,
                  'comment'      => $row->comment,

                  'created_at'   => $row->created_at,
                ] ], $xml_users );
            }
            header( 'Content-type: text/xml' );
         
            exit( $xml_users -> asXML() );
        }
          header( 'Content-type: text/xml' );
          exit( $xml_users -> asXML() );
       //return $xml_users;
        
    } 
    
    
  private function prepareXml ($order, &$xml_order)
  {
      foreach ( $order as $key => $value ) {
          if ( is_array( $value ) ) {
              if ( ! is_numeric( $key ) ) {
                  if ( $key == 'SERIALIZE' )
                    continue;

                  $subnode = $xml_order -> addChild( "{$key}" );
                  self::prepareXml( $value, $subnode );
              }
              else {
                  $subnode = $xml_order -> addChild( "item{$key}" );
                  self::prepareXml( $value, $subnode );
              }
          } else
              $xml_order -> addChild( $key, $value );
      }
  }

    
   
    
    /**
     * Створення нових з 1с
     * 
     * @param Request $request
     * @return object
     */
    public function InsertNewUserAction()
    {

        if( isset($_POST['xml']) ) {

            $rezult = simplexml_load_string(str_replace('&amp;','', $_POST['xml']));
            $user = new User();
            foreach( $rezult as $row ) {

                if(empty($row->web_id)){

                    if(count(User::where('user_code_1c','=',$row->code_1c)->get()) > 0){

                        User::where('user_code_1c','=',$row->code_1c)->update([
                            'name'         => $row->name,
                            'user_code_1c' => $row->code_1c,
                            'is_legal'     => $row->is_legal,
                            'VAT'          => $row->VAT,
                            'diller_id'    => $row->diller_id,
                            'agent_id'     => $row->agent_id,
                            'cf'           => $row->cf,
                            'type_price'   => $row->type_price,
                            'address'      => $row->address,
                            'type_pay'     => $row->type_pay,
                            'user_is_synk' => 1,
                        ]);

                    }else{
                        $password = str_random(8);
                        User::create([
                            'user_is_synk' => 1,
                            'name'         => $row->name,
                            'email'        => $row->email,
                            'user_code_1c' => $row->code_1c,
                            'is_legal'     => $row->is_legal,
                            'VAT'          => $row->VAT,
                            'diller_id'    => $row->diller_id,
                            'agent_id'     => $row->agent_id,
                            'cf'           => $row->cf,
                            'password'     => Hash::make($password),
                            'type_price'   => $row->type_price,
                            'address'      => $row->address,
                            'type_pay'     => $row->type_pay,
                        ]);
                    }
                }else{

                    if(count(User::where('id','=',$row->web_id)->get()) > 0){

                        User::where('id', '=', $row->web_id)->update([
                            'name' => $row->name,
                            'user_code_1c' => $row->code_1c,
                            'is_legal' => $row->is_legal,
                            'VAT' => $row->VAT,
                            'diller_id' => $row->diller_id,
                            'agent_id' => $row->agent_id,
                            'cf' => $row->cf,
                            'type_price' => $row->type_price,
                            'address' => $row->address,
                            'type_pay' => $row->type_pay,
                            'user_is_synk' => 1,
                        ]);

                    }else {

                        $password = str_random(8);

                        User::create([
                            'id'           => $row->web_id,
                            'user_is_synk' => 1,
                            'name'         => $row->name,
                            'email'        => $row->email,
                            'user_code_1c' => $row->code_1c,
                            'is_legal'     => $row->is_legal,
                            'VAT'          => $row->VAT,
                            'diller_id'    => $row->diller_id,
                            'agent_id'     => $row->agent_id,
                            'cf'           => $row->cf,
                            'password'     => Hash::make($password),
                            'type_price'   => $row->type_price,
                            'address'      => $row->address,
                            'type_pay'     => $row->type_pay,
                        ]);
                    }
                }

            }
            if($rezult) {
                return response()->json(['status' =>$err ?? 'OK']);
            } else {
                return response()->json(['errors' => 'ERROR_SQL'], 422);
            }
        } else {
            return response()->json(['errors' => 'ERROR_POST']);
        }
    }
    
    /**
     * Edit User 
     * @param - array $_POST['xml']
     * @return json
     */
     
    public function EditUserAction() 
    {
        if( isset($_POST['xml']) ) {   
            $rezult = simplexml_load_string($_POST['xml']);
            $user = new User();
            foreach( $rezult as $row ) {
                User::where('id','=',$row->web_id)->update([
                    'name'         => $row->name,
                    'user_code_1c' => $row->code_1c,
                    'is_legal'     => $row->is_legal,
                    'VAT'          => $row->VAT,
                    'diller_id'    => $row->diller_id,
                    'agent_id'     => $row->agent_id,
                    'cf'           => $row->cf,
                    'type_price'   => $row->type_price,
                    'address'      => $row->address,
                    'type_pay'     => $row->type_pay,
                    'type_price'   => $row->type_price,
                    'user_is_synk' => 1,
                ]);
                if($findUs = $user->iSsetUser($row->code_1c)) {
                    $user->EditUser($row, $findUs); 
                } else {
                
                    $err[] = [
                        'field_name' => 'user',
                        'message' =>"{$row->email} - NOT_FOUND",
                    ];
                    continue;
                }
            }
            return response()->json(['status' =>$err ?? 'OK']);
            
        } else {
              return response()->json(['errors' => 'ERROR_POST']);
        }
    }
    
    /**
     * Send Email
     * @param - $data['email'=>'','password'=>'']
     * 
     */
    public function SendMail($data){
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: " . ' MonicaLoretti ' . " <" . ' MonicaLoretti ' . ">\r\n";
        
        $email = $data['email'];
        $text = view('email_tpl.register')->with('user', $data);
        if ( mail( $email, 'Registration success on site MonicaLoretti!', $text, $headers ) ){
            return TRUE;
        }
    }
  
}
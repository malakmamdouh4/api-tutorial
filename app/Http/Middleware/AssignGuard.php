<?php 


namespace App\Http\Middleware;


use App\Traits\GeneralTrait;

use Closure;

use Tymon\JWTAuth\Exceptions\JWTException;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;

use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

//use Tymon\JWTAuth\JWTAuth;

use JWTAuth;



class AssignGuard extends BaseMiddleware

{
      
use GeneralTrait;
  
  /**
     * Handle an incoming request.
     *
     * @param  
\Illuminate\Http\Request  
$request
     * @param  \Closure  $next
     * @return mixed
     
*/
    public function handle($request, Closure $next , $guard = null)
   
 {
     
   if($guard != null)
    
    {

            auth()->shouldUse($guard);
         
   $token = $request->header('auth-token');
          
   $request->headers->set('auth-token',(string)$token,true);

   $request->headers->set('authorization','Bearer'.$token,true);
            
try
          
  {
//                $user = $this->auth->authenticate($request);
 
               $user = JWTAuth::parseToken()->authenticate();
         
   }
          
  catch (TokenExpiredException $e)
            
{
             
   return $this->returnError('303','UnAuthenticated user');
        
    }
         
   catch(JWTException $e)
         
   {
            
    return $this->returnError('404','TOken_Invalid',$e->getMessage());
       
     }
   
  }


        return $next($request);
  
  }

}

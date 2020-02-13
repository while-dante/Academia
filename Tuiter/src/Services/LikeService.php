<?php

namespace Tuiter\Services;

class LikeService
{
    protected $collection;
    public function __construct(\MongoDB\Collection $collection)
    {
        $this->collection = $collection;
    }
    private function likeExist(\Tuiter\Models\Like $like):bool{
        $objeto=$this->collection->findOne(array('postId'=>$like->getPostId(),'userId'=>$like->getUserId()));
        return !empty($objeto);
    }
    /**
     *Crea un objeto like en la base de datos a partir del post 
     *y el usuario recibidos.
     * @param \Tuiter\Models\User $user Este es el usuario que likea.
     * @param \Tuiter\Models\Post $post Este es el posteo a likear.
     * @return Bool Devuelve True si la operacion fue exitosa y False en caso 
     * contrario.
     */
     public function like(\Tuiter\Models\User $user, \Tuiter\Models\Post $post): bool
    {
        $unLike=new \Tuiter\Models\Like($post->getPostId(),$user->getUserId());
        if($this->likeExist($unLike)){
            return false;
        }
        $insert = $this->collection->insertOne(array(
            'likeId'=>$unLike->getLikeId(),
            'postId'=>$unLike->getPostId(),
            'userId'=>$unLike->getUserId()
        ));
        return !empty($insert);
    }
    /**
     * Recorre la base de datos, y devuelve la cantidad
     * de objetos que se corrspondan con el post recibido.
     *@param \Tuiter\Models\Post $post Recibe el post al que se le consultara
     * la cantidad de likes correspondientes.
     * @return Int Devuelve la contidad de likes de dicho post
     */
    public function count(\Tuiter\Models\Post $post): int
    {
        return $this->collection->count(array("postId"=>$post->getPostId()));
    }
    /**
     * Busca en la base de datos si hay un like que corresponda 
     * con el usuario y el post que se reciben, si existe lo elimina.
     * @param \Tuiter\Models\User $user Este es el usuario que intenta deslikear.
     * @param \Tuiter\Models\Post $post Este es el posteo a deslikear.
     * @return Bool Devuelve True si la operacion fue exitosa y False en caso 
     * contrario.
     */
    public function unlike(\Tuiter\Models\User $user,\Tuiter\Models\Post $post):bool{
        $unLike=new \Tuiter\Models\Like($post->getPostId(),$user->getUserId());
        if(!($this->likeExist($unLike))){
            return false;
        }
        $delete=$this->collection->deleteOne(array(
            'likeId'=>$unLike->getLikeId()
        ));
        return true;
    }
}

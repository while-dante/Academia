
####README####

Academia-Tuiter 
Una red social que permite registar usuarios, logear usuarios, que cada usuario
registrado va a poder postear, dar likes a posts y seguir a otros usuarios.  

Links:
Get:/  => Home --|_ Login
Get:/  => Home --|_ Registro
Get:/logOut
Get:/user/me => (Nuestros Post)
Get:/feed
Get:/{userName}
Get:/follow/{userName}
Get:/unFollow/{userName}
Get:/like/{postId}
Get:/unLike/{postId}
Post:/logIn
Post:/register
Post:/newPost

Services:

-LoginService -> Metodos:
    -login(string $userId, string $password) : User
    -logout() : void

-UserService -> Metodos:
    -register(string $userId, string $name, string $password) : Bool
    -getUser(string $userId) : User

-PostService -> Metodos:
    -createPost(string $content, User) : Post
    -getPost($postId) : Post
    -getAllPost(User) : array[Post]

-FollowService -> Metodos:
    -follow(User, User) : Boll
    -getFollower(User) : array[User]
    -getFollowed(User) : array[User]

-LikeService -> Metodos:
    -like(User, Post) : Bool
    -count(Post) : int
              
Actors:

-User/UserNotFound = Datos:
    -UserId
    -Name
    -Password
       
-Post = Datos:
    -PostId
    -Content
    -UserId

-Like = Datos:
    -LikeId
    -PostId
    -UserId

-Follow = Datos:
    -FollowId
    -FollowerId
    -FollowedId
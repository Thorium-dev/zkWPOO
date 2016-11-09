# zkWPOO
<p>
    Ces classes utilitaires permettent de faire de la Programmation Orientée Objet dans WordPress.
</p>

<h2>Installation</h2>
<p>
    Copiez et collez les fichiers dans votre projet puis incluez les dans vos pages en faisant <code>require_once WP_CONTENT_DIR . '/chemin_de_mon_projet/Blog.php';</code><br>
    Par exemple, si vous avez installé les fichiers vers <code>/themes/mon_theme/class/Blog.php</code>, incluez les en faisant <code>require_once WP_CONTENT_DIR . '/themes/mon_theme/class/Blog.php';</code>.
</p>

<h2>Description des fichiers</h2>
<p>
    Tous les fichiers sont des classes, sauf le fichier <code>requirements.php</code> qui permet d'inclure les fichiers 
    <code>Cat.php</code>, <code>Cats.php</code>, <code>Post.php</code> et <code>Posts.php</code>
</p>
<h3>
    <code>Blog.php</code>
</h3>
<p>
    Cette classe permet d'obtenir des informations sur le projet WordPress. Voici ses méthodes :
</p>
<ul>
    <li><code>name()</code> : Retourne le titre du site</li>
    <li><code>title()</code> : Retourne le titre du site</li>
    <li><code>description()</code> : Retourne le slogan du site</li>
    <li><code>desc()</code> : Retourne le slogan du site</li>
    <li><code>email()</code> : Retourne l'adresse de messagerie  l'administarteur</li>
    <li><code>charset()</code> : Retourne l'encodage</li>
    <li><code>version()</code> : Retourne la version de WordPress utilisée</li>
    <li><code>language()</code> : Retourne la langue utilisée</li>
    <li><code>lang()</code> : Retourne la langue utilisée</li>
    <li><code>style()</code> : Retourne l'url de la feuille de style</li>
    <li><code>css()</code> : Retourne l'url de la feuille de style</li>
    <li><code>path($path = null)</code> : Retourne une url. Par déaut, elle retourne l'url du dossier themes</li>
</ul>
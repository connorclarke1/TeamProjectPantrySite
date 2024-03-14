[![Review Assignment Due Date](https://classroom.github.com/assets/deadline-readme-button-24ddc0f5d75046c5622901739e7c5dd533143b0c8e959d652212380cedb1ea36.svg)](https://classroom.github.com/a/0zpPJvnn)
# Component 2 - Task

<p>This is a starter Laravel package that includes BREEZE for authentication and is scaffolded with TailwindCSS. 
</p>
<p>
Please see the assignment brief for a full set of requirements
</p>
<p>
Once the project is cloned to your workspace. You will need to:
</p>
<ul>
<li><b>composer install</b> (to populate the vendor folder)</li>
<li><b>npm install && npm run dev</b> (to populate node_modules)</li>
<li><b>cp .env.example .env</b> to create your own .env file</li>
<li><b>php artisan key:generate</b> to add a key to the .env file</li>
</ul>

<br />
<br />
<b>NOTE (For development on Che)</b>

<p>As Che will force https connection the following file needs to be amended<br />

app/Providers/AppServiceProvider.php <br />

<code>public function boot(): void
    <br />&nbsp;{
        <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\URL::forceScheme('https'); 
    <br />&nbsp;}
</code>

In addition as Che routes the test site through a different port - Vite as a live css development tool will likely not connect,
rather than <em>npm run dev</em>, use <em>npm run build</em> to see the site running.

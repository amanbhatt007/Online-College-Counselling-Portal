function signIn() {
    let oauth2Endpoint = "https://accounts.google.com/o/oauth2/v2/auth"
 
    let form = document.createElement('form')
    form.setAttribute('method', 'GET')
    form.setAttribute('action', oauth2Endpoint)
 
    let params ={
       "client_id":"323226487747-kmgs82fmvng2mprgi2ggk84jqvn68pm0.apps.googleusercontent.com",
       "redirect_uri":"http://127.0.0.1:5501/home.html",
       "response_type":"token",
       "scope":"https://www.googleapis.com/auth/gmail.readonly https://www.googleapis.com/auth/youtube.readonly",
       "include_granted_scope":'true',
       'state':'pass-through-value'
    }
 
    for(var p in params){
       let input = document.createElement('input')
       input.setAttribute('type','hidden')
       input.setAttribute('name',p)
       input.setAttribute('value',params[p])
       form.appendChild(input)
    }
 
    document.body.appendChild(form)
 
    form.submit();
 }
 
 
 
 
 
 document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission
 
    // Check if email and password are correct (you would typically do this on the server side)
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
 
    // Redirect to home page if email and password are correct
    if (email === "example@example.com" && password === "password") {
        window.location.href = "http://127.0.0.1:5501/home.html";
    } else {
        alert("Incorrect email or password");
    }
 });
 
 
 
 
 let toggleBtn = document.getElementById('toggle-btn');
 let body = document.body;
 let darkMode = localStorage.getItem('dark-mode');
 
 const enableDarkMode = () =>{
    toggleBtn.classList.replace('fa-sun', 'fa-moon');
    body.classList.add('dark');
    localStorage.setItem('dark-mode', 'enabled');
 }
 
 const disableDarkMode = () =>{
    toggleBtn.classList.replace('fa-moon', 'fa-sun');
    body.classList.remove('dark');
    localStorage.setItem('dark-mode', 'disabled');
 }
 
 if(darkMode === 'enabled'){
    enableDarkMode();
 }
 
 toggleBtn.onclick = (e) =>{
    darkMode = localStorage.getItem('dark-mode');
    if(darkMode === 'disabled'){
       enableDarkMode();
    }else{
       disableDarkMode();
    }
 }
 
 let profile = document.querySelector('.header .flex .profile');
 
 document.querySelector('#user-btn').onclick = () =>{
    profile.classList.toggle('active');
    search.classList.remove('active');
 }
 
 let search = document.querySelector('.header .flex .search-form');
 
 document.querySelector('#search-btn').onclick = () =>{
    search.classList.toggle('active');
    profile.classList.remove('active');
 }
 
 let sideBar = document.querySelector('.side-bar');
 
 document.querySelector('#menu-btn').onclick = () =>{
    sideBar.classList.toggle('active');
    body.classList.toggle('active');
 }
 
 document.querySelector('#close-btn').onclick = () =>{
    sideBar.classList.remove('active');
    body.classList.remove('active');
 }
 
 window.onscroll = () =>{
    profile.classList.remove('active');
    search.classList.remove('active');
 
    if(window.innerWidth < 1200){
       sideBar.classList.remove('active');
       body.classList.remove('active');
    }
 }
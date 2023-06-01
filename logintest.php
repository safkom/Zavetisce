<head>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<style>
    *,
*::after,
*::before {
  margin: 0;
  padding: 0;
  box-sizing: inherit;
  font-size: 62,5%;
}

body {
  height: 100vh;
	width: 100%;
  background: #0f2027; /* fallback for old browsers */
  background: linear-gradient(90deg, #C7C5F4, #776BCC);
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  color: #fff;
}

.form__label {
  font-family: 'Roboto', sans-serif;
  font-size: 1.2rem;
  margin-left: 2rem;
  margin-top: 0.7rem;
  display: block;
  transition: all 0.3s;
  transform: translateY(0rem);
  color: black;
}

.form__input {
  font-family: 'Roboto', sans-serif;
  color: #333;
  font-size: 1.2rem;
	margin: 0 auto;
  padding: 1.5rem 2rem;
  border-radius: 0.2rem;
  background-color: rgb(255, 255, 255);
  border: none;
  width: 70%;
  display: block;
  border-bottom: 0.3rem solid transparent;
  transition: all 0.3s;
}

.form__input:placeholder-shown + .form__label {
  opacity: 0;
  visibility: hidden;
  -webkit-transform: translateY(-4rem);
  transform: translateY(-4rem);
}
.container {
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 10px; /* Adding rounded corners */
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); /* Increasing the box shadow */
}
.container input[type="submit"] {
  width: 100%;
  padding: 10px;
  background-color: blue;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.container input[type="submit"]:hover {
  background-color: lightblue;
}
a {
    color: lightblue;
    text-decoration: none;
  }
#register{
    color: black;
}


    </style>
</head>
<body>
<div class="container">
  <h1>Prijava</h1>
<div class="form__group">
  <input type="text" class="form__input" id="name" placeholder="Mail" required="" />
  <label for="name" class="form__label">Mail</label>
  <input type="text" class="form__input" id="name" placeholder="Geslo" required="" />
  <label for="name" class="form__label">Geslo</label>
  <input type="submit" value="Pošlji">
  <p id = "register">Niste še uporabnik? <a href = "registracija.php">Pridobite dostop</a>
</div>
</div>
</body>

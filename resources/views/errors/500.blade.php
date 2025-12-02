<div class="container">
    <img src="https://i.imgur.com/qIufhof.png" style="width: 200px; height: 200px !important;">

    <h1>
        <span>Oops!</span> <br />
        Technical Error
    </h1>
    <p>It seems that we're experiencing technical difficulties at the moment</p>
    <div class="info">
        <!-- Kindly contact your Developer -->
        <p >Refresh the page to see if the problem resolves on its own.
        If the issue persists, we recommend coming back later.</p>
        <!-- <p>kindly contact your Developer for any further assistance.</p> -->
        <p>If you need immediate assistance or have any questions, kindly contact your Developer</p>
        <p> We appreciate your patience and understanding</p>

      </div>
        <div class="button-container">

            <button class="home-button">Back to Home</button>
        </div>

       <style>
       .button-container {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.contact-button, .home-button {
    background-color: transparent;
    color: #0a0a0a;
    border: 2px solid #000; /* Add a black border */
    padding: 10px 20px;
    font-size: 18px;
    cursor: pointer;
}

.contact-button:hover, .home-button:hover {
    background-color: transparent;
    border: 2px solid #0c0c0e; /* Change border color on hover */
    color: #ebebec; /* Change text color on hover */
    background-color: black;
}
    </p>
</div>

<style>
    @import url("https://fonts.googleapis.com/css?family=Fira+Code&display=swap");

* {
  margin: 0;
  padding: 0;
  font-family: "Fira Code", monospace;
}
body {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #ecf0f1;
}

.container {
  text-align: center;
  margin: auto;
  padding: 4em;
  img {
    width: 256px;
    height: 225px;
  }

  h1 {
    margin-top: 1rem;
    font-size: 35px;
    text-align: center;

    span {
      font-size: 60px;
    }
  }
  p {
    margin-top: 1rem;
  }

  p.info {
    margin-top: 4em;
    font-size: 12px;

    a {
      text-decoration: none;
      color: rgb(84, 84, 206);
    }
  }
}

</style>

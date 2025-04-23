<style>
    .container {
        width: 80%;
        margin: 0 auto;
        border-radius: 0 0 10px 10px;
        border: 1px solid #A9954C;
    }

    .body {
        margin: 8%;
    }

    table {width: 100%;}
    .title-table {
        color: #35571A;
        font-size: 1.3em;
        font-weight: bold;
        text-align: center;
        padding: 20px 0;
    }
</style>

<x-banner />

  <div class="container">

      <div class="body">
        The user {{ strtoupper($namefrom) }} Just changed their password
          <br><br>
          <table>
              <tbody>
                <tr>
                  <td colspan="3" class="title-table">User details</td>
                </tr>
                <tr>
                  <td colspan="3">
                      Account number: {{ $account }} <br>
                      Email: {{ $email }} <br>
                      <strong> {{ $name }} </strong> <br>
                      {{ $address }} <br>
                      {{ $city }} <br>
                      Phone number: {{ $phone }} <br>
                  </td>
                </tr>
              </tbody>
              </table>

      </div>

  </div>



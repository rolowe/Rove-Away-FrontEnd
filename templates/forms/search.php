<form action="results.php" method="POST" id="cache_flights">

  <div class="row">

    <div class="col-4">

      <input type="text" id="airport-search" name="iata" list="json-datalist" placeholder="Leaving from...">
      <datalist id="json-datalist">
        <select>
          <option value="LHR">London Heathrow</option>
          <option value="LGW">London Gatwick</option>
          <option value="BRS">Bristol</option>
        </select>
      </datalist>
    </div>

    <div class="col-4">
      <input type="date" id="dep_date" name="dep_date" class="datepicker fieldset__input  picker__input" placeholder="Leaving?">
      <span>(or leave blank for any date)</span>
    </div>

    <div class="col-4">
      <input type="date" id="ret_date" name="ret_date" class="datepicker fieldset__input  picker__input" placeholder="Coming home?">
      <span>(or leave blank to not specify)</span>
    </div>

    <div class="col-4">
      <select id="ppl" name="ppl" class="ui search dropdown">
        <option value="">How many?</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
      </select>
    </div>

  </div>

  <button type="submit" class="btn">Rove</button>
</form>

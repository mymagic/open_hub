<div class="container">
  <p></p>

  <p>
    <select class="js-Selector">
      <option value="-12.0">(GMT -12:00)</option>
      <option value="-11.0">(GMT -11:00)</option>
      <option value="-10.0">(GMT -10:00)</option>
      <option value="-9.0">(GMT -9:00)</option>
      <option value="-8.0">(GMT -8:00))</option>
      <option value="-7.0">(GMT -7:00))</option>
      <option value="-6.0">(GMT -6:00)</option>
      <option value="-5.0">(GMT -5:00)</option>
      <option value="-4.0">(GMT -4:00)</option>
      <option value="-3.0">(GMT -3:00)</option>
      <option value="-2.0">(GMT -2:00)</option>
      <option value="-1.0">(GMT -1:00)</option>
      <option value="0.0">(GMT)</option>
      <option value="1.0">(GMT +1:00)</option>
      <option value="2.0" selected="selected">(GMT +2:00)</option>
      <option value="3.0">(GMT +3:00)</option>
      <option value="4.0">(GMT +4:00)</option>
      <option value="5.0">(GMT +5:00)</option>
      <option value="6.0">(GMT +6:00)</option>
      <option value="7.0">(GMT +7:00)</option>
      <option value="8.0">(GMT +8:00)</option>
      <option value="9.0">(GMT +9:00)</option>
      <option value="9.5">(GMT +9:30)</option>
      <option value="10.0">(GMT +10:00)</option>
      <option value="11.0">(GMT +11:00)</option>
      <option value="12.0">(GMT +12:00)</option>
    </select>
  </p>

  <ul>
    <li><strong>Mentor Current Time:</strong> <span class="js-TimeUtc">2017-06-05T19:41:03Z</span></li>
    <li><strong>Selected Timezone Time:</strong> <span class="js-TimeLocal"></span></li>
  </ul>
</div>


<script>
const dateTimeUtc = new Date("2017-06-05T19:41:03Z");
document.querySelector(".js-TimeUtc").innerHTML = dateTimeUtc.toUTCString().split(" GMT")[0];

document.querySelector(".js-Selector").addEventListener("change", e => {
  const dateTimeLocal = new Date(dateTimeUtc.getTime() + e.target.value * 3600 * 1000);
  document.querySelector(".js-TimeLocal").innerHTML = dateTimeLocal.toUTCString().split(" GMT")[0];
});

const event = new Event("change");
document.querySelector(".js-Selector").dispatchEvent(event);

</script>

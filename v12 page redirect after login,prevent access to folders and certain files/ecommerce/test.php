<nav>

  <ul>
    <li><a href="/" class="active">Home</a></li>
    <li><a href="/collections/all">Books</a></li>
    <li><a href="/blogs/five-simple-steps-blog">Blog</a></li>
    <li><a href="/pages/about-us">About Us</a></li>
    <li><a href="/pages/support">Support</a></li>
  </ul>

  <select>
    <option value="" selected="selected">Select</option>

    <option value="/">Home</option>
    <option value="/collections/all">Books</option>
    <option value="/blogs/five-simple-steps-blog">Blog</option>
    <option value="/pages/about-us">About Us</option>
    <option value="/pages/support">Support</option>
  </select>

</nav>

<script type="text/javascript">
// Create the dropdown base
$("<select />").appendTo("nav");

// Create default option "Go to..."
$("<option />", {
 "selected": "selected",
 "value"   : "",
 "text"    : "Go to..."
}).appendTo("nav select");

// Populate dropdown with menu items
$("nav a").each(function() {
var el = $(this);
$("<option />", {
   "value"   : el.attr("href"),
   "text"    : el.text()
}).appendTo("nav select");
});

$("nav select").change(function() {
  window.location = $(this).find("option:selected").val();
});
</script>

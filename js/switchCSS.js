function switchCSS(val)
{
    var file = val.options[val.selectedIndex].value;
    
    var oldLink = document.getElementsByTagName("link").item(0);
    
    var newLink = document.createElement("link");
    newLink.setAttribute("rel", "stylesheet");
    newLink.setAttribute("type", "text/css");
    newLink.setAttribute("href", "css/" + file + ".css");
    
    document.getElementsByTagName("head").item(0).replaceChild(newLink, oldLink);
}
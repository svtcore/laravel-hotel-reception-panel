$(document).ready(function(){const e=$("#documentCountry").val();e&&$("#countryCode").val(e),$.ajax({url:"https://restcountries.com/v3.1/all",method:"GET",success:function(n){const t=$("#countryCode");n.sort(function(r,o){return r.name.common.localeCompare(o.name.common)}),$.each(n,function(r,o){const s=o.callingCodes?o.callingCodes[0]:"",u=s?` (+${s})`:"",a=$("<option>").val(o.cca2).text(o.name.common+u);t.append(a)});const c=$("#documentCountry").val();c&&t.val(c)},error:function(n){console.error("Error fetching countries:",n)}})});

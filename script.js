// Map subcounties to wards
const wardsBySubcounty = {
    "Kitui Central": ["Miambani", "Township", "Kyangwithya West", "Kyangwithya East", "Mulango"],
    "Mwingi North": ["Ngomeni", "Kyuso", "Mumoni", "Tseikuru", "Tharaka", "Katse"],
    // Add other subcounties and wards here
  };
  
  const subcountyDropdown = document.getElementById("subcounty");
  const wardDropdown = document.getElementById("ward");
  
  subcountyDropdown.addEventListener("change", function() {
    const selectedSubcounty = this.value;
    wardDropdown.innerHTML = '<option value="">Select Ward</option>';
  
    if (selectedSubcounty) {
      wardDropdown.disabled = false;
      wardsBySubcounty[selectedSubcounty].forEach(ward => {
        const option = document.createElement("option");
        option.value = ward;
        option.textContent = ward;
        wardDropdown.appendChild(option);
      });
    } else {
      wardDropdown.disabled = true;
    }
  });
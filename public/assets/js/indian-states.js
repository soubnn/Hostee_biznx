function getDistrict(state)
{
    if(state == "Andhra Pradesh")
    {
        $("#sellerStateCode").val('28');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Alluri Sitharama Raju'>Alluri Sitharama Raju</option>";
        newDistricts += "<option value='Anakapalli'>Anakapalli</option>";
        newDistricts += "<option value='Anantapuram'>Anantapuram</option>";
        newDistricts += "<option value='Annamaya'>Annamaya</option>";
        newDistricts += "<option value='Bapatla'>Bapatla</option>";
        newDistricts += "<option value='Chittoor'>Chittoor</option>";
        newDistricts += "<option value='East Godavari'>East Godavari</option>";
        newDistricts += "<option value='Eluru'>Eluru</option>";
        newDistricts += "<option value='Guntur'>Guntur</option>";
        newDistricts += "<option value='YSR Kadapa'>YSR Kadapa</option>";
        newDistricts += "<option value='Kakinada'>Kakinada</option>";
        newDistricts += "<option value='Kona Seema'>Kona Seema</option>";
        newDistricts += "<option value='Krishna'>Krishna</option>";
        newDistricts += "<option value='Kurnool'>Kurnool</option>";
        newDistricts += "<option value='Manyam'>Manyam</option>";
        newDistricts += "<option value='N.T.R.'>N.T.R.</option>";
        newDistricts += "<option value='Nandyal'>Nandyal</option>";
        newDistricts += "<option value='Palnadu'>Palnadu</option>";
        newDistricts += "<option value='Prakasam'>Prakasam</option>";
        newDistricts += "<option value='Sri Balaji'>Sri Balaji</option>";
        newDistricts += "<option value='Sri Satyasai'>Sri Satyasai</option>";
        newDistricts += "<option value='Sri Potti Sriramulu Nellore'>Sri Potti Sriramulu Nellore</option>";
        newDistricts += "<option value='Srikakulam'>Srikakulam</option>";
        newDistricts += "<option value='Visakhapatnam'>Visakhapatnam</option>";
        newDistricts += "<option value='Vizianagaram'>Vizianagaram</option>";
        newDistricts += "<option value='West Godavari'>West Godavari</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Arunachal Pradesh")
    {
        $("#sellerStateCode").val('12');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Anjaw'>Anjaw</option>";
        newDistricts += "<option value='Changlang'>Changlang</option>";
        newDistricts += "<option value='East Kameng'>East Kameng</option>";
        newDistricts += "<option value='East Siang'>East Siang</option>";
        newDistricts += "<option value='Kamle'>Kamle</option>";
        newDistricts += "<option value='Kra Daadi'>Kra Daadi</option>";
        newDistricts += "<option value='Kurung Kumey'>Kurung Kumey</option>";
        newDistricts += "<option value='Lepa Rada'>Lepa Rada</option>";
        newDistricts += "<option value='Lohit'>Lohit</option>";
        newDistricts += "<option value='Longding'>Longding</option>";
        newDistricts += "<option value='Lower Dibang Valley'>Lower Dibang Valley</option>";
        newDistricts += "<option value='Lower Siang'>Lower Siang</option>";
        newDistricts += "<option value='Lower Subansiri'>Lower Subansiri</option>";
        newDistricts += "<option value='Namsai'>Namsai</option>";
        newDistricts += "<option value='Pakke-Kessang'>Pakke-Kessang</option>";
        newDistricts += "<option value='Papum Pare'>Papum Pare</option>";
        newDistricts += "<option value='Shi Yomi'>Shi Yomi</option>";
        newDistricts += "<option value='Siang'>Siang</option>";
        newDistricts += "<option value='Tawang'>Tawang</option>";
        newDistricts += "<option value='Tirap'>Tirap</option>";
        newDistricts += "<option value='Upper Dibang Valley'>Upper Dibang Valley</option>";
        newDistricts += "<option value='Upper Siang'>Upper Siang</option>";
        newDistricts += "<option value='Upper Subansiri'>Upper Subansiri</option>";
        newDistricts += "<option value='West Kameng'>West Kameng</option>";
        newDistricts += "<option value='West Siang'>West Siang</option>";
        newDistricts += "<option value='Itanagar City Complex'>Itanagar City Complex</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Assam")
    {
        $("#sellerStateCode").val('18');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Bajali'>Bajali</option>";
        newDistricts += "<option value='Baksa'>Baksa</option>";
        newDistricts += "<option value='Barpeta'>Barpeta</option>";
        newDistricts += "<option value='Biswanath'>Biswanath</option>";
        newDistricts += "<option value='Bongaigaon'>Bongaigaon</option>";
        newDistricts += "<option value='Cachar'>Cachar</option>";
        newDistricts += "<option value='Charaideo'>Charaideo</option>";
        newDistricts += "<option value='Chirang'>Chirang</option>";
        newDistricts += "<option value='Darrang'>Darrang</option>";
        newDistricts += "<option value='Dhemaji'>Dhemaji</option>";
        newDistricts += "<option value='Dhubri'>Dhubri</option>";
        newDistricts += "<option value='Dibrugarh'>Dibrugarh</option>";
        newDistricts += "<option value='Dima Hasao'>Dima Hasao</option>";
        newDistricts += "<option value='Goalpara'>Goalpara</option>";
        newDistricts += "<option value='Golaghat'>Golaghat</option>";
        newDistricts += "<option value='Hailakandi'>Hailakandi</option>";
        newDistricts += "<option value='Hojai'>Hojai</option>";
        newDistricts += "<option value='Jorhat'>Jorhat</option>";
        newDistricts += "<option value='Kamrup'>Kamrup</option>";
        newDistricts += "<option value='Kamrup Metropolitan'>Kamrup Metropolitan</option>";
        newDistricts += "<option value='Karbi Anglong'>Karbi Anglong</option>";
        newDistricts += "<option value='Karimganj'>Karimganj</option>";
        newDistricts += "<option value='Kokrajhar'>Kokrajhar</option>";
        newDistricts += "<option value='Lakhimpur'>Lakhimpur</option>";
        newDistricts += "<option value='Majuli'>Majuli`</option>";
        newDistricts += "<option value='Morigaon'>Morigaon</option>";
        newDistricts += "<option value='Nagaon'>Nagaon</option>";
        newDistricts += "<option value='Nalbari'>Nalbari</option>";
        newDistricts += "<option value='Sivasagar'>Sivasagar</option>";
        newDistricts += "<option value='South Salmara Mankachar'>South Salmara Mankachar</option>";
        newDistricts += "<option value='Sonitpur'>Sonitpur</option>";
        newDistricts += "<option value='Tinsukia'>Tinsukia</option>";
        newDistricts += "<option value='Udalguri'>Udalguri</option>";
        newDistricts += "<option value='West Karbi Anglong'>West Karbi Anglong</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Bihar")
    {
        $("#sellerStateCode").val('10');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Araria'>Araria</option>";
        newDistricts += "<option value='Arwal'>Arwal</option>";
        newDistricts += "<option value='Aurangabad'>Aurangabad</option>";
        newDistricts += "<option value='Banka'>Banka</option>";
        newDistricts += "<option value='Begusarai'>Begusarai</option>";
        newDistricts += "<option value='Bhagalpur'>Bhagalpur</option>";
        newDistricts += "<option value='Bhojpur'>Bhojpur</option>";
        newDistricts += "<option value='Buxar'>Buxar</option>";
        newDistricts += "<option value='Darbhanga'>Darbhanga</option>";
        newDistricts += "<option value='East Champaran'>East Champaran</option>";
        newDistricts += "<option value='Gaya'>Gaya</option>";
        newDistricts += "<option value='Gopalganj'>Gopalganj</option>";
        newDistricts += "<option value='Jamui'>Jamui</option>";
        newDistricts += "<option value='Jehanabad'>Jehanabad</option>";
        newDistricts += "<option value='Kaimur'>Kaimur</option>";
        newDistricts += "<option value='Katihar'>Katihar</option>";
        newDistricts += "<option value='Khagaria'>Khagaria</option>";
        newDistricts += "<option value='Kishanganj'>Kishanganj</option>";
        newDistricts += "<option value='Lakhisarai'>Lakhisarai</option>";
        newDistricts += "<option value='Madhepura'>Madhepura</option>";
        newDistricts += "<option value='Madhubani'>Madhubani</option>";
        newDistricts += "<option value='Munger'>Munger</option>";
        newDistricts += "<option value='Muzaffarpur'>Muzaffarpur</option>";
        newDistricts += "<option value='Nalanda'>Nalanda</option>";
        newDistricts += "<option value='Nawada'>Nawada</option>";
        newDistricts += "<option value='Patna'>Patna</option>";
        newDistricts += "<option value='Purnia'>Purnia</option>";
        newDistricts += "<option value='Rohtas'>Rohtas</option>";
        newDistricts += "<option value='Saharsa'>Saharsa</option>";
        newDistricts += "<option value='Samastipur'>Samastipur</option>";
        newDistricts += "<option value='Saran'>Saran</option>";
        newDistricts += "<option value='Sheikhpura'>Sheikhpura</option>";
        newDistricts += "<option value='Sheohar'>Sheohar</option>";
        newDistricts += "<option value='Sitamarhi'>Sitamarhi</option>";
        newDistricts += "<option value='Siwan'>Siwan</option>";
        newDistricts += "<option value='Supaul'>Supaul</option>";
        newDistricts += "<option value='Vaishali'>Vaishali</option>";
        newDistricts += "<option value='West Champaran'>West Champaran</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Chattisgarh")
    {
        $("#sellerStateCode").val('22');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Balod'>Balod</option>";
        newDistricts += "<option value='Baloda Bazar-Bhatapara'>Baloda Bazar-Bhatapara</option>";
        newDistricts += "<option value='Balrampur'>Balrampur</option>";
        newDistricts += "<option value='Bastar'>Bastar</option>";
        newDistricts += "<option value='Bemetara'>Bemetara</option>";
        newDistricts += "<option value='Bijapur'>Bijapur</option>";
        newDistricts += "<option value='Bilaspur'>Bilaspur</option>";
        newDistricts += "<option value='Dantewada'>Dantewada</option>";
        newDistricts += "<option value='Dhamtari'>Dhamtari</option>";
        newDistricts += "<option value='Durg'>Durg</option>";
        newDistricts += "<option value='Gariaband'>Gariaband</option>";
        newDistricts += "<option value='Gaurella-Pendra-Marwahi'>Gaurella-Pendra-Marwahi</option>";
        newDistricts += "<option value='Janjgir-Champa'>Janjgir-Champa</option>";
        newDistricts += "<option value='Jashpur'>Jashpur</option>";
        newDistricts += "<option value='Kabirdham'>Kabirdham</option>";
        newDistricts += "<option value='Kanker'>Kanker</option>";
        newDistricts += "<option value='Kondagaon'>Kondagaon</option>";
        newDistricts += "<option value='Korba'>Korba</option>";
        newDistricts += "<option value='Korea'>Korea</option>";
        newDistricts += "<option value='Mahasamund'>Mahasamund</option>";
        newDistricts += "<option value='Manendragarh-Chirmiri-Bharatpur'>Manendragarh-Chirmiri-Bharatpur</option>";
        newDistricts += "<option value='Mohla Manpur'>Mohla Manpur</option>";
        newDistricts += "<option value='Mungeli'>Mungeli</option>";
        newDistricts += "<option value='Narayanpur'>Narayanpur</option>";
        newDistricts += "<option value='Raigarh'>Raigarh</option>";
        newDistricts += "<option value='Raipur'>Raipur</option>";
        newDistricts += "<option value='Rajnandgaon'>Rajnandgaon</option>";
        newDistricts += "<option value='Sarangarh-Bilaigarh'>Sarangarh-Bilaigarh</option>";
        newDistricts += "<option value='Shakti'>Shakti</option>";
        newDistricts += "<option value='Sukma'>Sukma</option>";
        newDistricts += "<option value='Surajpur'>Surajpur</option>";
        newDistricts += "<option value='Surguja'>Surguja</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Goa")
    {
        $("#sellerStateCode").val('30');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='North Goa'>North Goa</option>";
        newDistricts += "<option value='South Goa'>South Goa</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Gujarat")
    {
        $("#sellerStateCode").val('24');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Ahmedabad'>Ahmedabad</option>";
        newDistricts += "<option value='Amreli'>Amreli</option>";
        newDistricts += "<option value='Anand'>Anand</option>";
        newDistricts += "<option value='Aravalli'>Aravalli</option>";
        newDistricts += "<option value='Banaskantha'>Banaskantha</option>";
        newDistricts += "<option value='Bharuch'>Bharuch</option>";
        newDistricts += "<option value='Bhavnagar'>Bhavnagar</option>";
        newDistricts += "<option value='Botad'>Botad</option>";
        newDistricts += "<option value='Chhota Udaipur'>Chhota Udaipur</option>";
        newDistricts += "<option value='Dahod'>Dahod</option>";
        newDistricts += "<option value='Dang'>Dang</option>";
        newDistricts += "<option value='Devbhumi Dwarka'>Devbhumi Dwarka</option>";
        newDistricts += "<option value='Gandhinagar'>Gandhinagar</option>";
        newDistricts += "<option value='Gir Somnath'>Gir Somnath</option>";
        newDistricts += "<option value='Jamnagar'>Jamnagar</option>";
        newDistricts += "<option value='Junagadh'>Junagadh</option>";
        newDistricts += "<option value='Kheda'>Kheda</option>";
        newDistricts += "<option value='Kutch'>Kutch</option>";
        newDistricts += "<option value='Mahisagar'>Mahisagar</option>";
        newDistricts += "<option value='Mehsana'>Mehsana</option>";
        newDistricts += "<option value='Morbi'>Morbi</option>";
        newDistricts += "<option value='Narmada'>Narmada</option>";
        newDistricts += "<option value='Navsari'>Navsari</option>";
        newDistricts += "<option value='Panchmahal'>Panchmahal</option>";
        newDistricts += "<option value='Patan'>Patan</option>";
        newDistricts += "<option value='Porbandar'>Porbandar</option>";
        newDistricts += "<option value='Rajkot'>Rajkot</option>";
        newDistricts += "<option value='Sabarkantha'>Sabarkantha</option>";
        newDistricts += "<option value='Surat'>Surat</option>";
        newDistricts += "<option value='Surendranagar'>Surendranagar</option>";
        newDistricts += "<option value='Tapi'>Tapi</option>";
        newDistricts += "<option value='Vadodara'>Vadodara</option>";
        newDistricts += "<option value='Valsad'>Valsad</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Haryana")
    {
        $("#sellerStateCode").val('6');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Ambala'>Ambala</option>";
        newDistricts += "<option value='Bhiwani'>Bhiwani</option>";
        newDistricts += "<option value='Charkhi Dadri'>Charkhi Dadri</option>";
        newDistricts += "<option value='Faridabad'>Faridabad</option>";
        newDistricts += "<option value='Fatehabad'>Fatehabad</option>";
        newDistricts += "<option value='Gurugram'>Gurugram</option>";
        newDistricts += "<option value='Hisar'>Hisar</option>";
        newDistricts += "<option value='Jhajjar'>Jhajjar</option>";
        newDistricts += "<option value='Jind'>Jind</option>";
        newDistricts += "<option value='Kaithal'>Kaithal</option>";
        newDistricts += "<option value='Karnal'>Karnal</option>";
        newDistricts += "<option value='Kurukshetra'>Kurukshetra</option>";
        newDistricts += "<option value='Mahendragarh'>Mahendragarh</option>";
        newDistricts += "<option value='Nuh'>Nuh</option>";
        newDistricts += "<option value='Palwal'>Palwal</option>";
        newDistricts += "<option value='Panchkula'>Panchkula</option>";
        newDistricts += "<option value='Panipat'>Panipat</option>";
        newDistricts += "<option value='Rewari'>Rewari</option>";
        newDistricts += "<option value='Rohtak'>Rohtak</option>";
        newDistricts += "<option value='Sirsa'>Sirsa</option>";
        newDistricts += "<option value='Sonipat'>Sonipat</option>";
        newDistricts += "<option value='Yamunanagar'>Yamunanagar</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Himachal Pradesh")
    {
        $("#sellerStateCode").val('2');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Bilaspur'>Bilaspur</option>";
        newDistricts += "<option value='Chamba'>BChamba</option>";
        newDistricts += "<option value='Hamirpur'>Hamirpur</option>";
        newDistricts += "<option value='Kangra'>Kangra</option>";
        newDistricts += "<option value='Kinnaur'>Kinnaur</option>";
        newDistricts += "<option value='Kullu'>Kullu</option>";
        newDistricts += "<option value='Lahaul and Spiti'>Lahaul and Spiti</option>";
        newDistricts += "<option value='Mandi'>Mandi</option>";
        newDistricts += "<option value='Shimla'>Shimla</option>";
        newDistricts += "<option value='Sirmaur'>Sirmaur</option>";
        newDistricts += "<option value='Solan'>Solan</option>";
        newDistricts += "<option value='Una'>Una</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Jharkhand")
    {
        $("#sellerStateCode").val('20');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Bokaro'>Bokaro</option>";
        newDistricts += "<option value='Chatra'>Chatra</option>";
        newDistricts += "<option value='Deoghar'>Deoghar</option>";
        newDistricts += "<option value='Dhanbad'>Dhanbad</option>";
        newDistricts += "<option value='Dumka'>Dumka</option>";
        newDistricts += "<option value='East Singhbhum'>East Singhbhum</option>";
        newDistricts += "<option value='Garhwa'>Garhwa</option>";
        newDistricts += "<option value='Giridih'>Giridih</option>";
        newDistricts += "<option value='Godda'>Godda</option>";
        newDistricts += "<option value='Gumla'>Gumla</option>";
        newDistricts += "<option value='Hazaribag'>Hazaribag</option>";
        newDistricts += "<option value='Jamtara'>Jamtara</option>";
        newDistricts += "<option value='Khunti'>Khunti</option>";
        newDistricts += "<option value='Koderma'>Koderma</option>";
        newDistricts += "<option value='Latehar'>Latehar</option>";
        newDistricts += "<option value='Lohardaga'>Lohardaga</option>";
        newDistricts += "<option value='Pakur'>Pakur</option>";
        newDistricts += "<option value='Palamu'>Palamu</option>";
        newDistricts += "<option value='Ramgarh'>Ramgarh</option>";
        newDistricts += "<option value='Ranchi'>Ranchi</option>";
        newDistricts += "<option value='Sahibganj'>Sahibganj</option>";
        newDistricts += "<option value='Seraikela-Kharsawan'>Seraikela-Kharsawan</option>";
        newDistricts += "<option value='Simdega'>Simdega</option>";
        newDistricts += "<option value='West Singhbhum'>West Singhbhum</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Karnataka")
    {
        $("#sellerStateCode").val('29');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Bagalkot'>Bagalkot</option>";
        newDistricts += "<option value='Ballari'>Ballari</option>";
        newDistricts += "<option value='Belgaum'>Belgaum</option>";
        newDistricts += "<option value='Bengaluru Gramin'>Bengaluru Gramin</option>";
        newDistricts += "<option value='Bengaluru Nagara'>Bengaluru Nagara</option>";
        newDistricts += "<option value='Bidar'>Bidar</option>";
        newDistricts += "<option value='Chamarajanagara'>Chamarajanagara</option>";
        newDistricts += "<option value='Chikkaballapur'>Chikkaballapur</option>";
        newDistricts += "<option value='Chikkamagaluru'>Chikkamagaluru</option>";
        newDistricts += "<option value='Chitradurga'>Chitradurga</option>";
        newDistricts += "<option value='Dakshina Kannada'>Dakshina Kannada</option>";
        newDistricts += "<option value='Davanagere'>Davanagere</option>";
        newDistricts += "<option value='Dharwad'>Dharwad</option>";
        newDistricts += "<option value='Gadag'>Gadag</option>";
        newDistricts += "<option value='Kalaburagi'>Kalaburagi</option>";
        newDistricts += "<option value='Hassan'>Hassan</option>";
        newDistricts += "<option value='Haveri'>Haveri</option>";
        newDistricts += "<option value='Kodagu'>Kodagu</option>";
        newDistricts += "<option value='Kolar'>Kolar</option>";
        newDistricts += "<option value='Koppala'>Koppala</option>";
        newDistricts += "<option value='Mandya'>Mandya</option>";
        newDistricts += "<option value='Mysuru'>Mysuru</option>";
        newDistricts += "<option value='Raichur'>Raichur</option>";
        newDistricts += "<option value='Ramanagara'>Ramanagara</option>";
        newDistricts += "<option value='Shivamogga'>Shivamogga</option>";
        newDistricts += "<option value='Tumakuru'>Tumakuru</option>";
        newDistricts += "<option value='Udupi'>Udupi</option>";
        newDistricts += "<option value='Uttara Kannada'>Uttara Kannada</option>";
        newDistricts += "<option value='Vijayanagara'>Vijayanagara</option>";
        newDistricts += "<option value='Vijayapura'>Vijayapura</option>";
        newDistricts += "<option value='Yadgir'>Yadgir</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Kerala")
    {
        $("#sellerStateCode").val('32');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Alappuzha'>Alappuzha</option>";
        newDistricts += "<option value='Ernakulam'>Ernakulam</option>";
        newDistricts += "<option value='Idukki'>Idukki</option>";
        newDistricts += "<option value='Kannur'>Kannur</option>";
        newDistricts += "<option value='Kasaragod'>Kasaragod</option>";
        newDistricts += "<option value='Kollam'>Kollam</option>";
        newDistricts += "<option value='Kottayam'>Kottayam</option>";
        newDistricts += "<option value='Kozhikode'>Kozhikode</option>";
        newDistricts += "<option value='Malappuram'>Malappuram</option>";
        newDistricts += "<option value='Palakkad'>Palakkad</option>";
        newDistricts += "<option value='Pathanamthitta'>Pathanamthitta</option>";
        newDistricts += "<option value='Thrissur'>Thrissur</option>";
        newDistricts += "<option value='Thiruvananthapuram'>Thiruvananthapuram</option>";
        newDistricts += "<option value='Wayanad'>Wayanad</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Madhya Pradesh")
    {
        $("#sellerStateCode").val('23');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Agar Malwa'>Agar Malwa</option>";
        newDistricts += "<option value='Alirajpur'>Alirajpur</option>";
        newDistricts += "<option value='Anuppur'>Anuppur</option>";
        newDistricts += "<option value='Ashoknagar'>Ashoknagar</option>";
        newDistricts += "<option value='Balaghat'>Balaghat</option>";
        newDistricts += "<option value='Barwani'>Barwani</option>";
        newDistricts += "<option value='Betul'>Betul</option>";
        newDistricts += "<option value='Bhind'>Bhind</option>";
        newDistricts += "<option value='Bhopal'>Bhopal</option>";
        newDistricts += "<option value='Burhanpur'>Burhanpur</option>";
        newDistricts += "<option value='Chachaura-Binaganj'>Chachaura-Binaganj</option>";
        newDistricts += "<option value='Chhatarpur'>Chhatarpur</option>";
        newDistricts += "<option value='Chhindwara'>Chhindwara</option>";
        newDistricts += "<option value='Damoh'>Damoh</option>";
        newDistricts += "<option value='Datia'>Datia</option>";
        newDistricts += "<option value='Dewas'>Dewas</option>";
        newDistricts += "<option value='Dhar'>Dhar</option>";
        newDistricts += "<option value='Dindori'>Dindori</option>";
        newDistricts += "<option value='Guna'>Guna</option>";
        newDistricts += "<option value='Gwalior'>Gwalior</option>";
        newDistricts += "<option value='Harda'>Harda</option>";
        newDistricts += "<option value='Narmadapuram'>Narmadapuram</option>";
        newDistricts += "<option value='Indore'>Indore</option>";
        newDistricts += "<option value='Jabalpur'>Jabalpur</option>";
        newDistricts += "<option value='Jhabua'>Jhabua</option>";
        newDistricts += "<option value='Katni'>Katni</option>";
        newDistricts += "<option value='Khandwa'>Khandwa</option>";
        newDistricts += "<option value='Khargone'>Khargone</option>";
        newDistricts += "<option value='Maihar'>Maihar</option>";
        newDistricts += "<option value='Mandla'>Mandla</option>";
        newDistricts += "<option value='Mandsaur'>Mandsaur</option>";
        newDistricts += "<option value='Morena'>Morena</option>";
        newDistricts += "<option value='Narsinghpur'>Narsinghpur</option>";
        newDistricts += "<option value='Nagda'>Nagda</option>";
        newDistricts += "<option value='Neemuch'>Neemuch</option>";
        newDistricts += "<option value='Niwari'>Niwari</option>";
        newDistricts += "<option value='Panna'>Panna</option>";
        newDistricts += "<option value='Raisen'>Raisen</option>";
        newDistricts += "<option value='Rajgarh'>Rajgarh</option>";
        newDistricts += "<option value='Ratlam'>Ratlam</option>";
        newDistricts += "<option value='Rewa'>Rewa</option>";
        newDistricts += "<option value='Sagar'>Sagar</option>";
        newDistricts += "<option value='Satna'>Satna</option>";
        newDistricts += "<option value='Sehore'>Sehore</option>";
        newDistricts += "<option value='Seoni'>Seoni</option>";
        newDistricts += "<option value='Shahdol'>Shahdol</option>";
        newDistricts += "<option value='Shajapur'>Shajapur</option>";
        newDistricts += "<option value='Sheopur'>Sheopur</option>";
        newDistricts += "<option value='Shivpuri'>Shivpuri</option>";
        newDistricts += "<option value='Sidhi'>Sidhi</option>";
        newDistricts += "<option value='Singrauli'>Singrauli</option>";
        newDistricts += "<option value='Tikamgarh'>Tikamgarh</option>";
        newDistricts += "<option value='Ujjain'>Ujjain</option>";
        newDistricts += "<option value='Umaria'>Umaria</option>";
        newDistricts += "<option value='Vidisha'>Vidisha</option>";
        newDistricts += "<option value='Lavkushnagar'>Lavkushnagar</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Maharashtra")
    {
        $("#sellerStateCode").val('27');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Ahmednagar'>Ahmednagar</option>";
        newDistricts += "<option value='Akola'>Akola</option>";
        newDistricts += "<option value='Amravati'>Amravati</option>";
        newDistricts += "<option value='Aurangabad'>Aurangabad</option>";
        newDistricts += "<option value='Beed'>Beed</option>";
        newDistricts += "<option value='Bhandara'>Bhandara</option>";
        newDistricts += "<option value='Buldhana'>Buldhana</option>";
        newDistricts += "<option value='Chandrapur'>Chandrapur</option>";
        newDistricts += "<option value='Dhule'>Dhule</option>";
        newDistricts += "<option value='Gadchiroli'>Gadchiroli</option>";
        newDistricts += "<option value='Gondia'>Gondia</option>";
        newDistricts += "<option value='Hingoli'>Hingoli</option>";
        newDistricts += "<option value='Jalgaon'>Jalgaon</option>";
        newDistricts += "<option value='Jalna'>Jalna</option>";
        newDistricts += "<option value='Kolhapur'>Kolhapur</option>";
        newDistricts += "<option value='Latur'>Latur</option>";
        newDistricts += "<option value='Mumbai City'>Mumbai City</option>";
        newDistricts += "<option value='Mumbai suburban'>Mumbai suburban</option>";
        newDistricts += "<option value='Nanded'>Nanded</option>";
        newDistricts += "<option value='Nandurbar'>Nandurbar</option>";
        newDistricts += "<option value='Nagpur'>Nagpur</option>";
        newDistricts += "<option value='Nashik'>Nashik</option>";
        newDistricts += "<option value='Osmanabad'>Osmanabad</option>";
        newDistricts += "<option value='Palghar'>Palghar</option>";
        newDistricts += "<option value='Parbhani'>Parbhani</option>";
        newDistricts += "<option value='Pune'>Pune</option>";
        newDistricts += "<option value='Raigad'>Raigad</option>";
        newDistricts += "<option value='Ratnagiri'>Ratnagiri</option>";
        newDistricts += "<option value='Sangli'>Sangli</option>";
        newDistricts += "<option value='Satara'>Satara</option>";
        newDistricts += "<option value='Sindhudurg'>Sindhudurg</option>";
        newDistricts += "<option value='Solapur'>Solapur</option>";
        newDistricts += "<option value='Thane'>Thane</option>";
        newDistricts += "<option value='Wardha'>Wardha</option>";
        newDistricts += "<option value='Washim'>Washim</option>";
        newDistricts += "<option value='Yavatmal'>Yavatmal</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Manipur")
    {
        $("#sellerStateCode").val('14');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Bishnupur'>Bishnupur</option>";
        newDistricts += "<option value='Chandel'>Chandel</option>";
        newDistricts += "<option value='Churachandpur'>Churachandpur</option>";
        newDistricts += "<option value='Imphal East'>Imphal East</option>";
        newDistricts += "<option value='Imphal West'>Imphal West</option>";
        newDistricts += "<option value='Jiribam'>Jiribam</option>";
        newDistricts += "<option value='Kakching'>Kakching</option>";
        newDistricts += "<option value='Kamjong'>Kamjong</option>";
        newDistricts += "<option value='Kangpokpi'>Kangpokpi</option>";
        newDistricts += "<option value='Noney'>Noney</option>";
        newDistricts += "<option value='Pherzawl'>Pherzawl</option>";
        newDistricts += "<option value='Senapati'>Senapati</option>";
        newDistricts += "<option value='Tamenglong'>Tamenglong</option>";
        newDistricts += "<option value='Tengnoupal'>Tengnoupal</option>";
        newDistricts += "<option value='Thoubal'>Thoubal</option>";
        newDistricts += "<option value='Ukhrul'>Ukhrul</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Meghalaya")
    {
        $("#sellerStateCode").val('17');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='East Garo Hills'>East Garo Hills</option>";
        newDistricts += "<option value='East Khasi Hills'>East Khasi Hills</option>";
        newDistricts += "<option value='East Jaintia Hills'>East Jaintia Hills</option>";
        newDistricts += "<option value='North Garo Hills'>North Garo Hills</option>";
        newDistricts += "<option value='Ri Bhoi'>Ri Bhoi</option>";
        newDistricts += "<option value='South Garo Hills'>South Garo Hills</option>";
        newDistricts += "<option value='South West Garo Hills'>South West Garo Hills</option>";
        newDistricts += "<option value='South West Khasi Hills'>South West Khasi Hills</option>";
        newDistricts += "<option value='West Jaintia Hills'>West Jaintia Hills</option>";
        newDistricts += "<option value='West Garo Hills'>West Garo Hills</option>";
        newDistricts += "<option value='West Khasi Hills'>West Khasi Hills</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Mizoram")
    {
        $("#sellerStateCode").val('15');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Aizawl'>Aizawl</option>";
        newDistricts += "<option value='Champhai'>Champhai</option>";
        newDistricts += "<option value='Hnahthial'>Hnahthial</option>";
        newDistricts += "<option value='Khawzawl'>Khawzawl</option>";
        newDistricts += "<option value='Kolasib'>Kolasib</option>";
        newDistricts += "<option value='Lawngtlai'>Lawngtlai</option>";
        newDistricts += "<option value='Lunglei'>Lunglei</option>";
        newDistricts += "<option value='Mamit'>Mamit</option>";
        newDistricts += "<option value='Saiha'>Saiha</option>";
        newDistricts += "<option value='Saitual'>Saitual</option>";
        newDistricts += "<option value='Serchhip'>Serchhip</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Nagaland")
    {
        $("#sellerStateCode").val('13');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Chümoukedima'>Chümoukedima</option>";
        newDistricts += "<option value='Dimapur'>Dimapur</option>";
        newDistricts += "<option value='Kiphire'>Kiphire</option>";
        newDistricts += "<option value='Kohima'>Kohima</option>";
        newDistricts += "<option value='Longleng'>Longleng</option>";
        newDistricts += "<option value='Mokokchung'>Mokokchung</option>";
        newDistricts += "<option value='Mon'>Mon</option>";
        newDistricts += "<option value='Niuland'>Niuland</option>";
        newDistricts += "<option value='Noklak'>Noklak</option>";
        newDistricts += "<option value='Peren'>Peren</option>";
        newDistricts += "<option value='Phek'>Phek</option>";
        newDistricts += "<option value='Tseminyü'>Tseminyü</option>";
        newDistricts += "<option value='Tuensang'>Tuensang</option>";
        newDistricts += "<option value='Wokha'>Wokha</option>";
        newDistricts += "<option value='Zunheboto'>Zunheboto</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Odisha")
    {
        $("#sellerStateCode").val('21');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Angul'>Angul</option>";
        newDistricts += "<option value='Boudh'>Boudh</option>";
        newDistricts += "<option value='Bhadrak'>Bhadrak</option>";
        newDistricts += "<option value='Balangir'>Balangir</option>";
        newDistricts += "<option value='Bargarh'>Bargarh</option>";
        newDistricts += "<option value='Balasore'>Balasore</option>";
        newDistricts += "<option value='Cuttack'>Cuttack</option>";
        newDistricts += "<option value='Debagarh'>Debagarh</option>";
        newDistricts += "<option value='Dhenkanal'>Dhenkanal</option>";
        newDistricts += "<option value='Ganjam'>Ganjam</option>";
        newDistricts += "<option value='Gajapati'>Gajapati</option>";
        newDistricts += "<option value='Jharsuguda'>Jharsuguda</option>";
        newDistricts += "<option value='Jajpur'>Jajpura</option>";
        newDistricts += "<option value='Jagatsinghpur'>Jagatsinghpura</option>";
        newDistricts += "<option value='Khordha'>Khordha</option>";
        newDistricts += "<option value='Kendujhar'>Kendujhar</option>";
        newDistricts += "<option value='Kalahandi'>Kalahandi</option>";
        newDistricts += "<option value='Kandhamal'>Kandhamal</option>";
        newDistricts += "<option value='Koraput'>Koraput</option>";
        newDistricts += "<option value='Kendrapara'>Kendrapara</option>";
        newDistricts += "<option value='Malkangiri'>Malkangiri</option>";
        newDistricts += "<option value='Mayurbhanj'>Mayurbhanj</option>";
        newDistricts += "<option value='Nabarangpur'>Nabarangpur</option>";
        newDistricts += "<option value='Nuapada'>Nuapada</option>";
        newDistricts += "<option value='Nayagarh'>Nayagarh</option>";
        newDistricts += "<option value='Puri'>Puri</option>";
        newDistricts += "<option value='Rayagada'>Rayagada</option>";
        newDistricts += "<option value='Sambalpur'>Sambalpur</option>";
        newDistricts += "<option value='Subarnapur'>Subarnapur</option>";
        newDistricts += "<option value='Sundargarh'>Sundargarh</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Punjab")
    {
        $("#sellerStateCode").val('3');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Amritsar'>Amritsar</option>";
        newDistricts += "<option value='Barnala'>Barnala</option>";
        newDistricts += "<option value='Bathinda'>Bathinda</option>";
        newDistricts += "<option value='Firozpur'>Firozpur</option>";
        newDistricts += "<option value='Faridkot'>Faridkot</option>";
        newDistricts += "<option value='Fatehgarh Sahib'>Fatehgarh Sahib</option>";
        newDistricts += "<option value='Fazilka'>Fazilka</option>";
        newDistricts += "<option value='Gurdaspur'>Gurdaspur</option>";
        newDistricts += "<option value='Hoshiarpur'>Hoshiarpur</option>";
        newDistricts += "<option value='Jalandhar'>Jalandhar</option>";
        newDistricts += "<option value='Kapurthala'>Kapurthala</option>";
        newDistricts += "<option value='Ludhiana'>Ludhiana</option>";
        newDistricts += "<option value='Malerkotla'>Malerkotla</option>";
        newDistricts += "<option value='Mansa'>Mansa</option>";
        newDistricts += "<option value='Moga'>Moga</option>";
        newDistricts += "<option value='Sri Muktsar Sahib'>Sri Muktsar Sahib</option>";
        newDistricts += "<option value='Pathankot'>Pathankot</option>";
        newDistricts += "<option value='Patiala'>Patiala</option>";
        newDistricts += "<option value='Rupnagar'>Rupnagar</option>";
        newDistricts += "<option value='Sahibzada Ajit Singh Nagar'>Sahibzada Ajit Singh Nagar</option>";
        newDistricts += "<option value='Sangrur'>Sangrur</option>";
        newDistricts += "<option value='Shahid Bhagat Singh Nagar'>Shahid Bhagat Singh Nagar</option>";
        newDistricts += "<option value='Tarn Taran'>Tarn Taran</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Rajasthan")
    {
        $("#sellerStateCode").val('8');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Ajmer'>Ajmer</option>";
        newDistricts += "<option value='Alwar'>Alwar</option>";
        newDistricts += "<option value='Bikaner'>Bikaner</option>";
        newDistricts += "<option value='Barmer'>Barmer</option>";
        newDistricts += "<option value='Banswara'>Banswara</option>";
        newDistricts += "<option value='Bharatpur'>Bharatpur</option>";
        newDistricts += "<option value='Baran'>Baran</option>";
        newDistricts += "<option value='Bundi'>Bundi</option>";
        newDistricts += "<option value='Bhilwara'>Bhilwara</option>";
        newDistricts += "<option value='Churu'>Churu</option>";
        newDistricts += "<option value='Chittorgarh'>Chittorgarh</option>";
        newDistricts += "<option value='Dausa'>Dausa</option>";
        newDistricts += "<option value='Dholpur'>Dholpur</option>";
        newDistricts += "<option value='Dungarpur'>Dungarpur</option>";
        newDistricts += "<option value='Sri Ganganagar'>Sri Ganganagar</option>";
        newDistricts += "<option value='Hanumangarh'>Hanumangarh</option>";
        newDistricts += "<option value='Jhunjhunu'>Jhunjhunu</option>";
        newDistricts += "<option value='Jalore'>Jalore</option>";
        newDistricts += "<option value='Jodhpur'>Jodhpur</option>";
        newDistricts += "<option value='Jaipur'>Jaipur</option>";
        newDistricts += "<option value='Jaisalmer'>Jaisalmer</option>";
        newDistricts += "<option value='Jhalawar'>Jhalawar</option>";
        newDistricts += "<option value='Karauli'>Karauli</option>";
        newDistricts += "<option value='Kota'>Kota</option>";
        newDistricts += "<option value='Nagaur'>Nagaur</option>";
        newDistricts += "<option value='Pali'>Pali</option>";
        newDistricts += "<option value='Pratapgarh'>Pratapgarh</option>";
        newDistricts += "<option value='Rajsamand'>Rajsamand</option>";
        newDistricts += "<option value='Sikar'>Sikar</option>";
        newDistricts += "<option value='Sawai Madhopur'>Sawai Madhopur</option>";
        newDistricts += "<option value='Sirohi'>Sirohi</option>";
        newDistricts += "<option value='Tonk'>Tonk</option>";
        newDistricts += "<option value='Udaipur'>Udaipur</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Sikkim")
    {
        $("#sellerStateCode").val('11');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='East Sikkim'>East Sikkim</option>";
        newDistricts += "<option value='North Sikkim'>North Sikkim</option>";
        newDistricts += "<option value='Pakyong'>Pakyong</option>";
        newDistricts += "<option value='Soreng'>Soreng</option>";
        newDistricts += "<option value='South Sikkim'>South Sikkim</option>";
        newDistricts += "<option value='West Sikkim'>West Sikkim</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Tamil Nadu")
    {
        $("#sellerStateCode").val('33');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Ariyalur'>Ariyalur</option>";
        newDistricts += "<option value='Chengalpattu'>Chengalpattu</option>";
        newDistricts += "<option value='Chennai'>Chennai</option>";
        newDistricts += "<option value='Coimbatore'>Coimbatore</option>";
        newDistricts += "<option value='Cuddalore'>Cuddalore</option>";
        newDistricts += "<option value='Dharmapuri'>Dharmapuri</option>";
        newDistricts += "<option value='Dindigul'>Dindigul</option>";
        newDistricts += "<option value='Erode'>Erode</option>";
        newDistricts += "<option value='Kallakurichi'>Kallakurichi</option>";
        newDistricts += "<option value='Kanchipuram'>Kanchipuram</option>";
        newDistricts += "<option value='Kanyakumari'>Kanyakumari</option>";
        newDistricts += "<option value='Karur'>Karur</option>";
        newDistricts += "<option value='Krishnagiri'>Krishnagiri</option>";
        newDistricts += "<option value='Madurai'>Madurai</option>";
        newDistricts += "<option value='Mayiladuthurai'>Mayiladuthurai</option>";
        newDistricts += "<option value='Nagapattinam'>Nagapattinam</option>";
        newDistricts += "<option value='Nilgiris'>Nilgiris</option>";
        newDistricts += "<option value='Namakkal'>Namakkal</option>";
        newDistricts += "<option value='Perambalur'>Perambalur</option>";
        newDistricts += "<option value='Pudukkottai'>Pudukkottai</option>";
        newDistricts += "<option value='Ramanathapuram'>Ramanathapuram</option>";
        newDistricts += "<option value='Ranipet'>Ranipet</option>";
        newDistricts += "<option value='Salem'>Salem</option>";
        newDistricts += "<option value='Sivaganga'>Sivaganga</option>";
        newDistricts += "<option value='Tenkasi'>Tenkasi</option>";
        newDistricts += "<option value='Tiruppur'>Tiruppur</option>";
        newDistricts += "<option value='Tiruchirappalli'>Tiruchirappalli</option>";
        newDistricts += "<option value='Theni'>Theni</option>";
        newDistricts += "<option value='Tirunelveli'>Tirunelveli</option>";
        newDistricts += "<option value='Thanjavur'>Thanjavur</option>";
        newDistricts += "<option value='Thoothukudi'>Thoothukudi</option>";
        newDistricts += "<option value='Tirupattur'>Tirupattur</option>";
        newDistricts += "<option value='Tiruvallur'>Tiruvallur</option>";
        newDistricts += "<option value='Tiruvarur'>Tiruvarur</option>";
        newDistricts += "<option value='Tiruvannamalai'>Tiruvannamalai</option>";
        newDistricts += "<option value='Vellore'>Vellore</option>";
        newDistricts += "<option value='Viluppuram'>Viluppuram</option>";
        newDistricts += "<option value='Virudhunagar'>Virudhunagar</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Telangana")
    {
        $("#sellerStateCode").val('36');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Adilabad'>Adilabad</option>";
        newDistricts += "<option value='Bhadradri Kothagudem'>Bhadradri Kothagudem</option>";
        newDistricts += "<option value='Hanamkonda'>Hanamkonda</option>";
        newDistricts += "<option value='Hyderabad'>Hyderabad</option>";
        newDistricts += "<option value='Jagtial'>Jagtial</option>";
        newDistricts += "<option value='Jangaon'>Jangaon</option>";
        newDistricts += "<option value='Jayashankar Bhupalpally'>Jayashankar Bhupalpally</option>";
        newDistricts += "<option value='Jogulamba Gadwal'>Jogulamba Gadwal</option>";
        newDistricts += "<option value='Kamareddy'>Kamareddy</option>";
        newDistricts += "<option value='Karimnagar'>Karimnagar</option>";
        newDistricts += "<option value='Khammam'>Khammam</option>";
        newDistricts += "<option value='Kumuram Bheem Asifabad'>Kumuram Bheem Asifabad</option>";
        newDistricts += "<option value='Mahabubabad'>Mahabubabad</option>";
        newDistricts += "<option value='Mahbubnagar'>Mahbubnagar</option>";
        newDistricts += "<option value='Mancherial'>Mancherial</option>";
        newDistricts += "<option value='Medak'>Medak</option>";
        newDistricts += "<option value='Medchal–Malkajgiri'>Medchal–Malkajgiri</option>";
        newDistricts += "<option value='Mulugu'>Mulugu</option>";
        newDistricts += "<option value='Nalgonda'>Nalgonda</option>";
        newDistricts += "<option value='Narayanpet'>Narayanpet</option>";
        newDistricts += "<option value='Nagarkurnool'>Nagarkurnool</option>";
        newDistricts += "<option value='Nirmal'>Nirmal</option>";
        newDistricts += "<option value='Nizamabad'>Nizamabad</option>";
        newDistricts += "<option value='Peddapalli'>Peddapalli</option>";
        newDistricts += "<option value='Rajanna Sircilla'>Rajanna Sircilla</option>";
        newDistricts += "<option value='Ranga Reddy'>Ranga Reddy</option>";
        newDistricts += "<option value='Sangareddy'>Sangareddy</option>";
        newDistricts += "<option value='Siddipet'>Siddipet</option>";
        newDistricts += "<option value='Suryapet'>Suryapet</option>";
        newDistricts += "<option value='Vikarabad'>Vikarabad</option>";
        newDistricts += "<option value='Wanaparthy'>Wanaparthy</option>";
        newDistricts += "<option value='Warangal'>Warangal</option>";
        newDistricts += "<option value='Yadadri Bhuvanagiri'>Yadadri Bhuvanagiri</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Tripura")
    {
        $("#sellerStateCode").val('16');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Dhalai'>Dhalai</option>";
        newDistricts += "<option value='Gomati'>Gomati</option>";
        newDistricts += "<option value='Khowai'>Khowai</option>";
        newDistricts += "<option value='North Tripura'>North Tripura</option>";
        newDistricts += "<option value='Sepahijala'>Sepahijala</option>";
        newDistricts += "<option value='South Tripura'>South Tripura</option>";
        newDistricts += "<option value='Unokoti'>Unokoti</option>";
        newDistricts += "<option value='West Tripura'>West Tripura</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Uttar Pradesh")
    {
        $("#sellerStateCode").val('9');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Agra'>Agra</option>";
        newDistricts += "<option value='Aligarh'>Aligarh</option>";
        newDistricts += "<option value='Allahabad'>Allahabad</option>";
        newDistricts += "<option value='Ambedkar Nagar'>Ambedkar Nagar</option>";
        newDistricts += "<option value='Amethi'>Amethi</option>";
        newDistricts += "<option value='Amroha'>Amroha</option>";
        newDistricts += "<option value='Auraiya'>Auraiya</option>";
        newDistricts += "<option value='Azamgarh'>Azamgarh</option>";
        newDistricts += "<option value='Bagpat'>Bagpat</option>";
        newDistricts += "<option value='Bahraich'>Bahraich</option>";
        newDistricts += "<option value='Ballia'>Ballia</option>";
        newDistricts += "<option value='Balrampur'>Balrampur</option>";
        newDistricts += "<option value='Banda'>Banda</option>";
        newDistricts += "<option value='Barabanki'>Barabanki</option>";
        newDistricts += "<option value='Bareilly'>Bareilly</option>";
        newDistricts += "<option value='Basti'>Basti</option>";
        newDistricts += "<option value='Bhadohi'>Bhadohi</option>";
        newDistricts += "<option value='Bijnor'>Bijnor</option>";
        newDistricts += "<option value='Budaun'>Budaun</option>";
        newDistricts += "<option value='Bulandshahr'>Bulandshahr</option>";
        newDistricts += "<option value='Chandauli'>Chandauli</option>";
        newDistricts += "<option value='Chitrakoot'>Chitrakoot</option>";
        newDistricts += "<option value='Deoria'>Deoria</option>";
        newDistricts += "<option value='Etah'>Etah</option>";
        newDistricts += "<option value='Etawah'>Etawah</option>";
        newDistricts += "<option value='Faizabad'>Faizabad</option>";
        newDistricts += "<option value='Farrukhabad'>Farrukhabad</option>";
        newDistricts += "<option value='Fatehpur'>Fatehpur</option>";
        newDistricts += "<option value='Firozabad'>Firozabad</option>";
        newDistricts += "<option value='Gautam Buddha Nagar'>Gautam Buddha Nagar</option>";
        newDistricts += "<option value='Ghaziabad'>Ghaziabad</option>";
        newDistricts += "<option value='Ghazipur'>Ghazipur</option>";
        newDistricts += "<option value='Gonda'>Gonda</option>";
        newDistricts += "<option value='Gorakhpur'>Gorakhpur</option>";
        newDistricts += "<option value='Hamirpur'>Hamirpur</option>";
        newDistricts += "<option value='Hapur'>Hapur</option>";
        newDistricts += "<option value='Hardoi'>Hardoi</option>";
        newDistricts += "<option value='Hathras'>Hathras</option>";
        newDistricts += "<option value='Jalaun'>Jalaun</option>";
        newDistricts += "<option value='Jaunpur'>Jaunpur</option>";
        newDistricts += "<option value='Jhansi'>Jhansi</option>";
        newDistricts += "<option value='Kannauj'>Kannauj</option>";
        newDistricts += "<option value='Kanpur Dehat'>Kanpur Dehat</option>";
        newDistricts += "<option value='Kanpur Nagar'>Kanpur Nagar</option>";
        newDistricts += "<option value='Kasganj'>Kasganj</option>";
        newDistricts += "<option value='Kaushambi'>Kaushambi</option>";
        newDistricts += "<option value='Kushinagar'>Kushinagar</option>";
        newDistricts += "<option value='Lakhimpur Kheri'>Lakhimpur Kheri</option>";
        newDistricts += "<option value='Lalitpur'>Lalitpur</option>";
        newDistricts += "<option value='Lucknow'>Lucknow</option>";
        newDistricts += "<option value='Maharajganj'>Maharajganj</option>";
        newDistricts += "<option value='Mahoba'>Mahoba</option>";
        newDistricts += "<option value='Mainpuri'>Mainpuri</option>";
        newDistricts += "<option value='Mathura'>Mathura</option>";
        newDistricts += "<option value='Mau'>Mau</option>";
        newDistricts += "<option value='Meerut'>Meerut</option>";
        newDistricts += "<option value='Mirzapur'>Mirzapur</option>";
        newDistricts += "<option value='Moradabad'>Moradabad</option>";
        newDistricts += "<option value='Muzaffarnagar'>Muzaffarnagar</option>";
        newDistricts += "<option value='Pilibhit'>Pilibhit</option>";
        newDistricts += "<option value='Pratapgarh'>Pratapgarh</option>";
        newDistricts += "<option value='Raebareli'>Raebareli</option>";
        newDistricts += "<option value='Rampur'>Rampur</option>";
        newDistricts += "<option value='Saharanpur'>Saharanpur</option>";
        newDistricts += "<option value='Sambhal'>Sambhal</option>";
        newDistricts += "<option value='Sant Kabir Nagar'>Sant Kabir Nagar</option>";
        newDistricts += "<option value='Shahjahanpur'>Shahjahanpur</option>";
        newDistricts += "<option value='Shamli'>Shamli</option>";
        newDistricts += "<option value='Shravasti'>Shravasti</option>";
        newDistricts += "<option value='Siddharthnagar'>Siddharthnagar</option>";
        newDistricts += "<option value='Sitapur'>Sitapur</option>";
        newDistricts += "<option value='Sonbhadra'>Sonbhadra</option>";
        newDistricts += "<option value='Sultanpur'>Sultanpur</option>";
        newDistricts += "<option value='Unnao'>Unnao</option>";
        newDistricts += "<option value='Varanasi'>Varanasi</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Uttarakhand")
    {
        $("#sellerStateCode").val('5');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Almora'>Almora</option>";
        newDistricts += "<option value='Bageshwar'>Bageshwar</option>";
        newDistricts += "<option value='Chamoli'>Chamoli</option>";
        newDistricts += "<option value='Champawat'>Champawat</option>";
        newDistricts += "<option value='Dehradun'>Dehradun</option>";
        newDistricts += "<option value='Didihat'>Didihat</option>";
        newDistricts += "<option value='Haridwar'>Haridwar</option>";
        newDistricts += "<option value='Kotdwar'>Kotdwar</option>";
        newDistricts += "<option value='Nainital'>Nainital</option>";
        newDistricts += "<option value='Pauri Garhwal'>Pauri Garhwal</option>";
        newDistricts += "<option value='Pithoragarh'>Pithoragarh</option>";
        newDistricts += "<option value='Ranikhet'>Ranikhet</option>";
        newDistricts += "<option value='Rudraprayag'>Rudraprayag</option>";
        newDistricts += "<option value='Tehri Garhwal'>Tehri Garhwal</option>";
        newDistricts += "<option value='Udham Singh Nagar'>Udham Singh Nagar</option>";
        newDistricts += "<option value='Uttarkashi'>Uttarkashi</option>";
        newDistricts += "<option value='Yamunotri'>Yamunotri</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "West Bengal")
    {
        $("#sellerStateCode").val('19');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Alipurduar'>Alipurduar</option>";
        newDistricts += "<option value='Bankura'>Bankura</option>";
        newDistricts += "<option value='Paschim Bardhaman'>Paschim Bardhaman</option>";
        newDistricts += "<option value='Purba Bardhaman'>Purba Bardhaman</option>";
        newDistricts += "<option value='Birbhum'>Birbhum</option>";
        newDistricts += "<option value='Cooch Behar'>Cooch Behar</option>";
        newDistricts += "<option value='Dakshin Dinajpur'>Dakshin Dinajpur</option>";
        newDistricts += "<option value='Darjeeling'>Darjeeling</option>";
        newDistricts += "<option value='Hooghly'>Hooghly</option>";
        newDistricts += "<option value='Howrah'>Howrah</option>";
        newDistricts += "<option value='Jalpaiguri'>Jalpaiguri</option>";
        newDistricts += "<option value='Jhargram'>Jhargram</option>";
        newDistricts += "<option value='Kalimpong'>Kalimpong</option>";
        newDistricts += "<option value='Kolkata'>Kolkata</option>";
        newDistricts += "<option value='Maldah'>Udham Singh Nagar</option>";
        newDistricts += "<option value='Murshidabad'>Murshidabad</option>";
        newDistricts += "<option value='Nadia'>Nadia</option>";
        newDistricts += "<option value='North 24 Parganas'>North 24 Parganas</option>";
        newDistricts += "<option value='Paschim Medinipur'>Paschim Medinipur</option>";
        newDistricts += "<option value='Purba Medinipur'>Purba Medinipur</option>";
        newDistricts += "<option value='Purulia'>Purulia</option>";
        newDistricts += "<option value='South 24 Parganas'>South 24 Parganas</option>";
        newDistricts += "<option value='Uttar Dinajpur'>Uttar Dinajpur</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Andaman and Nicobar")
    {
        $("#sellerStateCode").val('35');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Nicobar'>Nicobar</option>";
        newDistricts += "<option value='North and Middle Andaman'>North and Middle Andaman</option>";
        newDistricts += "<option value='South Andaman'>South Andaman</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Chandigarh")
    {
        $("#sellerStateCode").val('4');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Chandigarh'>Chandigarh</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Dadra and Nagar Haveli and Daman and Diu")
    {
        $("#sellerStateCode").val('26');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Daman'>Daman</option>";
        newDistricts += "<option value='Diu'>Diu</option>";
        newDistricts += "<option value='Dadra and Nagar Haveli'>Dadra and Nagar Haveli</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Jammu and Kashmir")
    {
        $("#sellerStateCode").val('1');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Anantnag'>Anantnag</option>";
        newDistricts += "<option value='Budgam'>Budgam</option>";
        newDistricts += "<option value='Bandipore'>Bandipore</option>";
        newDistricts += "<option value='Baramulla'>Baramulla</option>";
        newDistricts += "<option value='Doda'>Doda</option>";
        newDistricts += "<option value='Ganderbal'>Ganderbal</option>";
        newDistricts += "<option value='Jammu'>Jammu</option>";
        newDistricts += "<option value='Kathua'>Kathua</option>";
        newDistricts += "<option value='Kishtwar'>Kishtwar</option>";
        newDistricts += "<option value='Kulgam'>Kulgam</option>";
        newDistricts += "<option value='Kupwara'>Kupwara</option>";
        newDistricts += "<option value='Poonch'>Poonch</option>";
        newDistricts += "<option value='Pulwama'>Pulwama</option>";
        newDistricts += "<option value='Rajouri'>Rajouri</option>";
        newDistricts += "<option value='Ramban'>Ramban</option>";
        newDistricts += "<option value='Reasi'>Reasi</option>";
        newDistricts += "<option value='Samba'>Samba</option>";
        newDistricts += "<option value='Shopian'>Shopian</option>";
        newDistricts += "<option value='Srinagar'>Srinagar</option>";
        newDistricts += "<option value='Udhampur'>Udhampur</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Ladakh")
    {
        $("#sellerStateCode").val('38');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Kargil'>Kargil</option>";
        newDistricts += "<option value='Leh'>Leh</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Lakshadweep")
    {
        $("#sellerStateCode").val('31');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Lakshadweep'>Lakshadweep</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Puducherry")
    {
        $("#sellerStateCode").val('34');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Karaikal'>Karaikal</option>";
        newDistricts += "<option value='Mahé'>Mahé</option>";
        newDistricts += "<option value='Puducherry'>Puducherry</option>";
        newDistricts += "<option value='Yanam'>Yanam</option>";
        $("#sellerDistrict").html(newDistricts);
    }
    else if(state == "Capital Territory of Delhi")
    {
        $("#sellerStateCode").val('7');
        var newDistricts = "<option value=''>Select District</option>";
        newDistricts += "<option value='Central Delhi'>Central Delhi</option>";
        newDistricts += "<option value='East Delhi'>East Delhi</option>";
        newDistricts += "<option value='New Delhi'>New Delhi</option>";
        newDistricts += "<option value='North Delhi'>North Delhi</option>";
        newDistricts += "<option value='North East Delhi'>North East Delhi</option>";
        newDistricts += "<option value='North West Delhi'>North West Delhi</option>";
        newDistricts += "<option value='Shahdara'>Shahdara</option>";
        newDistricts += "<option value='South Delhi'>South Delhi</option>";
        newDistricts += "<option value='South East Delhi'>South East Delhi</option>";
        newDistricts += "<option value='South West Delhi'>South West Delhi</option>";
        newDistricts += "<option value='West Delhi'>West Delhi</option>";
        $("#sellerDistrict").html(newDistricts);
    }
}


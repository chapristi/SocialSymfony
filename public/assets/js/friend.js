import axios from 'axios';


document.getElementById("js-select").addEventListener("click", function(event){
    event.preventDefault()

    axios.post(path,{})
        .then(function (response) {
            //console.table est une fonction interessante qui formate un tableau de facon estetique dans la console

            document.getElementById('pop-up').innerHTML = response.data[0].message
            if (response.data[0].isFriend === true){
                document.getElementById('pop-up').className = "alert alert-success"
                document.getElementById('js-selec').src="{{ asset('assets/img/1500455.png')  }}"

            }else {
                document.getElementById('pop-up').className = "alert alert-danger"
                document.getElementById('js-selec').src="{{ asset('assets/img/add-friend.png') }}"
            }



        })
        .catch(function (error) {
            console.log(error.response.data);
        });

});
document.addEventListener("DOMContentLoaded", () => {

    const URL_API = "http://localhost:8080/api_v1/pessoas_completo/controllers/pessoaController.php";
    
    const btnListar    = document.getElementById("listarPessoas");
    const lista        = document.querySelector(".lista");
    const btnCadastrar = document.querySelector('form #cadastrar')

    const forms = document.querySelectorAll('form')


    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault()
            if(form.className == "pesquisar") {
                lista.innerHTML = ''
                const id = document.querySelector('form input[type="number"]').value
                fetch(URL_API + '?idPessoa='+ id)
                .then(resposta=>{
                    return resposta.json()
                })
                .then(dados => {
                    console.log(dados)
                    const item = document.createElement("li")
                    item.innerText = dados.nome
                    lista.appendChild(item)
                })
            } else if(form.className == "cadastrar") {
                const nome = document.querySelector('form.cadastrar input[type="text"]').value
                fetch(URL_API, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({nome:nome})
                })
                .then(resposta => {
                    console.log('Status HTTP:', resposta.status);
                    return resposta.json();
                })
                .then(dados => {
                    console.log(dados.mensagem);
                })
            } else if(form.className == "deletar") {
                const id = document.querySelector('.deletar input').value;
                console.log(id)
                fetch(URL_API + '?idPessoa=' + id, {
                    method: 'DELETE',
                })
                .then(resposta => {
                    return resposta.json()
                })
                .then(dados => {
                    alert(dados.mensagem)
                })
            }
        })
    });
    

    btnListar.addEventListener("click", () => {
        lista.innerHTML = ''
        fetch(URL_API)
        .then(resposta => {
            return resposta.json();
        })
        .then(dados => {
            dados.forEach(pessoa => {
                const item = document.createElement("li");
            
                item.textContent = `${pessoa.id} - ${pessoa.nome} `;
                
                const btnAlterar = document.createElement("button");
                btnAlterar.textContent = "Alterar";
                
                btnAlterar.addEventListener("click", () => {
                    prepararAlteracao(pessoa); 
                });
                
                item.appendChild(btnAlterar);
                lista.appendChild(item);
            });
        })
    })

    function prepararAlteracao(pessoa) {
        const novoNome = prompt("Digite o novo nome para" + pessoa.nome + ":", pessoa.nome)
        fetch(URL_API, {
            method: "PUT",
            headers:{
                "Content-type": "application/json"
            },
            body: JSON.stringify({
                id: pessoa.id,
                nome: novoNome
            })
        })
        .then(response => {
            if(response) {
                return response.json()
            }
        })
        .then(dados => {
            alert(dados.mensagem)
        })
    }
    
})



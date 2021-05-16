# OincPay

<p align="center"><img src="https://i.imgur.com/gsrWbwJ.jpg" width="200"></p>

<p align="center" size="12px">(instruções em português no final da página)</p>

## What is OincPay?

OincPay is your new e-wallet. Faster than a lightning, safe and easy to use. With OincPay, you'll be able to transfer any amount to anyone: family members, friends, customers and companies. OincPay includes the following features:

- API-based services, made with love <3;
- Manage user's wallets;
- Create transactions between users;
- Available anywhere, everywhere; 
- No real piglets were harm while building this API;

## How can I run OincPay?

Oincpay is built with Laravel 8 and PHP 7.4. It already comes with everything you need to run the project. Just follow these simple instructions on Linux:

1) Clone the repository

```python
git clone https://github.com/leafarcathal/oincpay.git
```

2) Build the docker

```python
sudo docker-compose up -d
```

3) Once the containers are up, run the following commands:

```python
sudo docker-compose exec app bash # access the container
php artisan migrate # run all the migrations
php artisan db:seed # run all project seeds
```
## Documentation

You can find our API documentation on Postman. [Check our collection](https://www.getpostman.com/collections/1618666038bdeffc5826).




## O que é OincPay?

OincPay é a sua nova carteira virtual. Mais rápida que um raio, segura e fácil de usar. Com OincPay, você poderá transferir qualquer quantia de dinheiro para qualquer um: familiares, amigos, clientes e empresas. OincPay possui as seguintes características:

- Serviço baseado em APIs, feito com amor <3;
- Gerencie carteiras virtuais de seus usuários;
- Crie transferências entre usuários;
- Disponível em todas as plataformas, sempre; 
- Nenhum porquinho foi machucado durante a construção dessa API;

## Como eu posso instalar a OincPay?

Oincpay foi criado com Laravel 8 e PHP 7.4. Ele já vem com tudo oq ue você precisa para usar o projeto. Siga as seguintes instruções para a instalação em um ambiente Linux:

1) Clone o repositório

```python
git clone https://github.com/leafarcathal/oincpay.git
```

2) Construa os containers de docker

```python
sudo docker-compose up -d
```

3) Quando os containers estiverem prontos, rode os seguintes comandos.

```python
sudo docker-compose exec app bash # acessa o container
php artisan migrate # roda todas as migrations
php artisan db:seed # roda todos as seeds do projeto
```
## Documentação

Você encontra a nossa documentação de API no Postman. [Dê uma olhada na nossa collection](https://www.getpostman.com/collections/1618666038bdeffc5826).
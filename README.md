# Guia de Implementação: Classes de Serviço para Consumo de API e DTOs

Este documento descreve as melhores práticas e estrutura recomendada para implementar classes de serviço para consumo de APIs, uso de DTOs (Data Transfer Objects) e outras informações relevantes para organizar e manter o código limpo e escalável.

---

## **1. Estrutura Geral do Projeto**

A organização do projeto deve seguir uma estrutura clara e modular. Abaixo está uma sugestão de estrutura de diretórios para lidar com serviços de consumo de APIs e DTOs:

```
app/
├── Services/
│   ├── ApiConsumerService.php
│   
├── DTOs/
│   ├── PostDTO.php
```

- **`Services/`**: Contém classes responsáveis por consumir APIs externas.
- **`DTOs/`**: Contém classes que representam objetos de transferência de dados, garantindo que os dados sejam manipulados de forma consistente.

---

## **2. Classe de Serviço para Consumo de API**

As classes de serviço são responsáveis por encapsular a lógica de comunicação com APIs externas. Elas devem ser reutilizáveis, testáveis e desacopladas.

### Exemplo: `ApiConsumerService.php`

```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\DTO\PostDTO;

class ApiConsumerService
{
    public function getPosts(): array
    {
        // Consumindo a API pública
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');

        if ($response->successful()) {
            // Mapeando os dados para o DTO
            return array_map(function ($post) {
                return new PostDTO(
                    id: $post['id'],
                    title: $post['title'],
                    body: $post['body']
                );
            }, $response->json());
        }

        return []; // Retorna um array vazio em caso de falha
    }
}
```

### Boas Práticas:
- **Base URI**: Configure a URI base no cliente Guzzle para evitar repetição.
- **Timeout**: Defina um tempo limite para evitar requisições pendentes indefinidamente.
- **Tratamento de Erros**: Use `try-catch` para capturar exceções e fornecer mensagens de erro claras.

---

## **3. DTO (Data Transfer Object)**

Os DTOs são usados para garantir que os dados sejam transferidos de forma consistente entre camadas do sistema. Eles ajudam a evitar o uso de arrays associativos desestruturados.

### Exemplo: `PostDTO.php`

```php
<?php

namespace App\DTO;

class PostDTO
{
    public function __construct(
        public int $id, 
        public string $title, 
        public string $body
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
        ];
    }
}
```

### Boas Práticas:
- **Imutabilidade**: Evite modificar os dados do DTO após sua criação.
- **Validação**: Valide os dados no construtor para garantir consistência.
- **Conversão em Massa**: Use métodos estáticos para converter arrays em coleções de DTOs.

---

## **4. Exemplo de Uso**

### Controlador: `ApiConsumerController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiConsumerService;

class ApiConsumerController extends Controller
{
    protected $apiConsumerService;

    public function __construct(ApiConsumerService $apiConsumerService)
    {
        $this->apiConsumerService = $apiConsumerService;
    }

    public function index()
    {
        // Consumindo dados do serviço
        $posts = $this->apiConsumerService->getPosts();

        // Retornando para a view
        return view('welcome', compact('posts'));
    }
}
```

---

## **5. Benefícios da Abordagem**

1. **Manutenção**: A lógica de consumo de APIs está centralizada nas classes de serviço, facilitando alterações futuras.
2. **Reutilização**: As classes de serviço podem ser reutilizadas em diferentes partes do sistema.
3. **Consistência**: Os DTOs garantem que os dados sejam manipulados de forma consistente em todo o sistema.
4. **Testabilidade**: Tanto os serviços quanto os DTOs podem ser facilmente testados de forma isolada.

---
## **6. Conclusão**

Seguindo esta abordagem, você terá um sistema modular, escalável e fácil de manter. A separação de responsabilidades entre serviços, DTOs e controladores garante que cada parte do sistema tenha um propósito claro, facilitando o desenvolvimento e a evolução do projeto.

# AliMENTE - Sistema de Nutrição e Bem-estar

## Atualizando o Projeto no Git

### 1. Verificar Mudanças

Antes de atualizar, verifique quais arquivos foram modificados:
```bash
git status
```

### 2. Adicionar Mudanças

Você pode adicionar arquivos específicos:
```bash
git add caminho/do/arquivo
```

Ou adicionar todas as mudanças:
```bash
git add .
```

### 3. Criar Commit

Crie um commit com uma mensagem descritiva:
```bash
git commit -m "Descrição das mudanças realizadas"
```

### 4. Atualizar Repositório Remoto

Envie as mudanças para o repositório remoto:
```bash
git push origin main
```

### Fluxo Completo de Atualização

1. Verifique o status:
```bash
git status
```

2. Adicione as mudanças:
```bash
git add .
```

3. Crie o commit:
```bash
git commit -m "Sua mensagem aqui"
```

4. Envie para o repositório:
```bash
git push origin main
```

### Dicas Importantes

1. **Antes de começar a trabalhar**:
   ```bash
   git pull origin main
   ```
   Isso garante que você está trabalhando com a versão mais recente.

2. **Se houver conflitos**:
   ```bash
   # Veja quais arquivos têm conflitos
   git status
   
   # Resolva os conflitos manualmente nos arquivos
   # Depois adicione os arquivos resolvidos
   git add .
   
   # Complete o merge
   git commit -m "Resolvendo conflitos"
   ```

3. **Para ver o histórico de commits**:
   ```bash
   git log
   ```

4. **Para desfazer mudanças antes do commit**:
   ```bash
   # Desfazer mudanças em um arquivo específico
   git checkout -- caminho/do/arquivo
   
   # Desfazer todas as mudanças
   git checkout -- .
   ```

5. **Para desfazer o último commit (mantendo as mudanças)**:
   ```bash
   git reset --soft HEAD~1
   ```

### Boas Práticas

1. **Commits Frequentes**:
   - Faça commits pequenos e frequentes
   - Cada commit deve representar uma mudança lógica
   - Use mensagens claras e descritivas

2. **Branches**:
   - Para novas funcionalidades, crie uma branch:
     ```bash
     git checkout -b nome-da-feature
     ```
   - Após terminar, faça merge com a main:
     ```bash
     git checkout main
     git merge nome-da-feature
     ```

3. **Mensagens de Commit**:
   - Use verbos no imperativo
   - Seja claro e conciso
   - Exemplo: "Adiciona validação de formulário"

4. **Antes de Pushar**:
   - Verifique se o código está funcionando
   - Revise suas mudanças com `git diff`
   - Certifique-se que não há arquivos sensíveis (.env, etc)

### Comandos Úteis

```bash
# Ver mudanças em arquivos específicos
git diff caminho/do/arquivo

# Ver mudanças staged
git diff --staged

# Cancelar staged changes
git reset HEAD caminho/do/arquivo

# Ver branches
git branch

# Criar e mudar para nova branch
git checkout -b nome-da-branch

# Mudar de branch
git checkout nome-da-branch

# Atualizar lista de branches remotas
git fetch origin

# Ver mudanças antes de pull
git fetch origin
git diff main origin/main
```

## Instalação do Projeto

[Mantido o conteúdo anterior de instalação...]


<!-- open AI api を利用したRAG実装 -->
import openai

# OpenAI APIキーの設定
openai.api_key = 'YOUR_OPENAI_API_KEY'

def generate_with_rag(prompt, documents):
    # RAGのリクエストを準備
    request = {
        "model": "text-davinci-002",
        "documents": documents,
        "query": prompt,
        "max_tokens": 150,
        "stop": ["\n", "<|endoftext|>"]
    }

    # OpenAI APIを使って生成を実行
    response = openai.Completion.create(**request)

    # 生成されたテキストを返す
    return response.choices[0].text.strip()

# 使用例
prompt = "What are the benefits of using RAG?"
documents = [
    "RAG improves text generation by integrating retrieval-based information.",
    "It enhances accuracy and diversity in generated text.",
    "Real-time applications benefit significantly from RAG's capabilities."
]

generated_text = generate_with_rag(prompt, documents)
print(generated_text)



<!-- OpenAIのAssistants APIでRAG(検索拡張生成)を実装-->
from openai import OpenAI
import os
client = OpenAI()
client.api_key = os.environ['OPENAI_API_KEY']  # 環境変数から取得

# ファイルのアップロード
my_file = client.files.create(
  file=open("company.txt", "rb"),
  purpose="assistants"
)
file_id = my_file.id

# アシスタントの生成
my_assistant = client.beta.assistants.create(
    instructions="添付されたファイルは日本語のテキスト形式です。このファイルを開いて質問に答えてください。",
    name="secretary",
    model="gpt-4-turbo-preview",
    tools=[{"type": "code_interpreter"}],
    file_ids=[file_id]
)
assistant_id = my_assistant.id

# スレッドの生成
thread = client.beta.threads.create()
thread_id = thread.id

# スレッドに紐づけたメッセージの生成
message = client.beta.threads.messages.create(
    thread_id= thread_id,
    role="user",
    content="会社名を教えてください。"
)

# スレッドの実行
run = client.beta.threads.runs.create(
  thread_id=thread_id,
  assistant_id=assistant_id,
)
run_id = run.id

while run.status in ["queued", "in_progress", "completed"]:
    run = client.beta.threads.runs.retrieve(
        thread_id=thread_id,
        run_id=run_id
    )
    if run.status == "completed":
        messages = client.beta.threads.messages.list(
            thread_id=thread_id
        )
        print(messages.data[0].content[0].text.value)
        break

# ファイル等の削除
print(client.files.delete(file_id=file_id))  # ファイルの削除
print(client.beta.assistants.delete(assistant_id))  # アシスタントの削除
print(client.beta.threads.delete(thread_id=thread_id))  # スレッドの削除

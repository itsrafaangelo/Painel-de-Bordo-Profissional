@extends('layouts.app')

@section('title', 'Novo Snippet')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Novo Snippet</h1>
        <p class="text-gray-600">Crie um novo snippet de código com syntax highlighting.</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('snippets.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Título do Snippet *
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ex: Função para validar CNPJ"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @php $selectedProject = request('project_id') ?? old('project_id'); @endphp
                <div>
                    <label for="project_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Projeto (opcional)
                    </label>
                    @if(request('project_id'))
                        <input type="hidden" name="project_id" value="{{ request('project_id') }}">
                        <div class="px-3 py-2 bg-gray-100 rounded text-gray-700">{{ $projects->firstWhere('id', request('project_id'))->name ?? 'Projeto selecionado' }}</div>
                    @else
                        <select name="project_id" 
                                id="project_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Sem projeto</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ $selectedProject == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                    @error('project_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="language" class="block text-sm font-medium text-gray-700 mb-2">
                        Linguagem *
                    </label>
                    <select name="language" 
                            id="language"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="">Selecione a linguagem</option>
                        <option value="php" {{ old('language') === 'php' ? 'selected' : '' }}>PHP</option>
                        <option value="javascript" {{ old('language') === 'javascript' ? 'selected' : '' }}>JavaScript</option>
                        <option value="python" {{ old('language') === 'python' ? 'selected' : '' }}>Python</option>
                        <option value="java" {{ old('language') === 'java' ? 'selected' : '' }}>Java</option>
                        <option value="csharp" {{ old('language') === 'csharp' ? 'selected' : '' }}>C#</option>
                        <option value="cpp" {{ old('language') === 'cpp' ? 'selected' : '' }}>C++</option>
                        <option value="c" {{ old('language') === 'c' ? 'selected' : '' }}>C</option>
                        <option value="ruby" {{ old('language') === 'ruby' ? 'selected' : '' }}>Ruby</option>
                        <option value="go" {{ old('language') === 'go' ? 'selected' : '' }}>Go</option>
                        <option value="rust" {{ old('language') === 'rust' ? 'selected' : '' }}>Rust</option>
                        <option value="swift" {{ old('language') === 'swift' ? 'selected' : '' }}>Swift</option>
                        <option value="kotlin" {{ old('language') === 'kotlin' ? 'selected' : '' }}>Kotlin</option>
                        <option value="scala" {{ old('language') === 'scala' ? 'selected' : '' }}>Scala</option>
                        <option value="html" {{ old('language') === 'html' ? 'selected' : '' }}>HTML</option>
                        <option value="css" {{ old('language') === 'css' ? 'selected' : '' }}>CSS</option>
                        <option value="sql" {{ old('language') === 'sql' ? 'selected' : '' }}>SQL</option>
                        <option value="bash" {{ old('language') === 'bash' ? 'selected' : '' }}>Bash</option>
                        <option value="powershell" {{ old('language') === 'powershell' ? 'selected' : '' }}>PowerShell</option>
                        <option value="yaml" {{ old('language') === 'yaml' ? 'selected' : '' }}>YAML</option>
                        <option value="json" {{ old('language') === 'json' ? 'selected' : '' }}>JSON</option>
                        <option value="xml" {{ old('language') === 'xml' ? 'selected' : '' }}>XML</option>
                        <option value="markdown" {{ old('language') === 'markdown' ? 'selected' : '' }}>Markdown</option>
                        <option value="typescript" {{ old('language') === 'typescript' ? 'selected' : '' }}>TypeScript</option>
                        <option value="vue" {{ old('language') === 'vue' ? 'selected' : '' }}>Vue</option>
                        <option value="react" {{ old('language') === 'react' ? 'selected' : '' }}>React</option>
                        <option value="angular" {{ old('language') === 'angular' ? 'selected' : '' }}>Angular</option>
                        <option value="dart" {{ old('language') === 'dart' ? 'selected' : '' }}>Dart</option>
                        <option value="r" {{ old('language') === 'r' ? 'selected' : '' }}>R</option>
                        <option value="matlab" {{ old('language') === 'matlab' ? 'selected' : '' }}>MATLAB</option>
                        <option value="perl" {{ old('language') === 'perl' ? 'selected' : '' }}>Perl</option>
                        <option value="lua" {{ old('language') === 'lua' ? 'selected' : '' }}>Lua</option>
                        <option value="haskell" {{ old('language') === 'haskell' ? 'selected' : '' }}>Haskell</option>
                        <option value="elixir" {{ old('language') === 'elixir' ? 'selected' : '' }}>Elixir</option>
                        <option value="clojure" {{ old('language') === 'clojure' ? 'selected' : '' }}>Clojure</option>
                        <option value="erlang" {{ old('language') === 'erlang' ? 'selected' : '' }}>Erlang</option>
                        <option value="fsharp" {{ old('language') === 'fsharp' ? 'selected' : '' }}>F#</option>
                        <option value="ocaml" {{ old('language') === 'ocaml' ? 'selected' : '' }}>OCaml</option>
                        <option value="nim" {{ old('language') === 'nim' ? 'selected' : '' }}>Nim</option>
                        <option value="zig" {{ old('language') === 'zig' ? 'selected' : '' }}>Zig</option>
                        <option value="crystal" {{ old('language') === 'crystal' ? 'selected' : '' }}>Crystal</option>
                        <option value="julia" {{ old('language') === 'julia' ? 'selected' : '' }}>Julia</option>
                        <option value="d" {{ old('language') === 'd' ? 'selected' : '' }}>D</option>
                        <option value="fortran" {{ old('language') === 'fortran' ? 'selected' : '' }}>Fortran</option>
                        <option value="cobol" {{ old('language') === 'cobol' ? 'selected' : '' }}>COBOL</option>
                        <option value="pascal" {{ old('language') === 'pascal' ? 'selected' : '' }}>Pascal</option>
                        <option value="ada" {{ old('language') === 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="lisp" {{ old('language') === 'lisp' ? 'selected' : '' }}>Lisp</option>
                        <option value="prolog" {{ old('language') === 'prolog' ? 'selected' : '' }}>Prolog</option>
                        <option value="smalltalk" {{ old('language') === 'smalltalk' ? 'selected' : '' }}>Smalltalk</option>
                        <option value="forth" {{ old('language') === 'forth' ? 'selected' : '' }}>Forth</option>
                        <option value="assembly" {{ old('language') === 'assembly' ? 'selected' : '' }}>Assembly</option>
                        <option value="verilog" {{ old('language') === 'verilog' ? 'selected' : '' }}>Verilog</option>
                        <option value="vhdl" {{ old('language') === 'vhdl' ? 'selected' : '' }}>VHDL</option>
                        <option value="tcl" {{ old('language') === 'tcl' ? 'selected' : '' }}>Tcl</option>
                        <option value="awk" {{ old('language') === 'awk' ? 'selected' : '' }}>AWK</option>
                        <option value="sed" {{ old('language') === 'sed' ? 'selected' : '' }}>sed</option>
                        <option value="groovy" {{ old('language') === 'groovy' ? 'selected' : '' }}>Groovy</option>
                        <option value="j" {{ old('language') === 'j' ? 'selected' : '' }}>J</option>
                        <option value="apl" {{ old('language') === 'apl' ? 'selected' : '' }}>APL</option>
                        <option value="k" {{ old('language') === 'k' ? 'selected' : '' }}>K</option>
                        <option value="q" {{ old('language') === 'q' ? 'selected' : '' }}>Q</option>
                        <option value="m" {{ old('language') === 'm' ? 'selected' : '' }}>M</option>
                        <option value="n" {{ old('language') === 'n' ? 'selected' : '' }}>N</option>
                        <option value="o" {{ old('language') === 'o' ? 'selected' : '' }}>O</option>
                        <option value="p" {{ old('language') === 'p' ? 'selected' : '' }}>P</option>
                        <option value="q" {{ old('language') === 'q' ? 'selected' : '' }}>Q</option>
                        <option value="r" {{ old('language') === 'r' ? 'selected' : '' }}>R</option>
                        <option value="s" {{ old('language') === 's' ? 'selected' : '' }}>S</option>
                        <option value="t" {{ old('language') === 't' ? 'selected' : '' }}>T</option>
                        <option value="u" {{ old('language') === 'u' ? 'selected' : '' }}>U</option>
                        <option value="v" {{ old('language') === 'v' ? 'selected' : '' }}>V</option>
                        <option value="w" {{ old('language') === 'w' ? 'selected' : '' }}>W</option>
                        <option value="x" {{ old('language') === 'x' ? 'selected' : '' }}>X</option>
                        <option value="y" {{ old('language') === 'y' ? 'selected' : '' }}>Y</option>
                        <option value="z" {{ old('language') === 'z' ? 'selected' : '' }}>Z</option>
                    </select>
                    @error('language')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                        Código *
                    </label>
                    <textarea name="code" 
                              id="code" 
                              rows="15"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm"
                              placeholder="Cole ou digite seu código aqui...">{{ old('code') }}</textarea>
                    @error('code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('snippets.index') }}" 
                       class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        Criar Snippet
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection 
<?php

	function select() {

		$contato = array();
		$fp = fopen('contato.txt', 'r');

        if($fp) {
            while(!feof($fp)) {
				$arr = array();
                $id = fgets($fp);
				$dados = fgets($fp);
				if(!empty($dados)) {
					$arr = explode("#", $dados);
					$contato[$id] = $arr;
				}
			}
			fclose($fp);
		}

		return $contato;
	}

	function select_where($id) {

		$contato = select();

		foreach ($contato as $chave => $dados) {
			// echo "$cpf=$chave<br>";
			if(strcmp($id, trim($chave)) == 0) { 
				return $dados;
			}
		}

		return null;	
	}

	function insert($contato) {

		$fp = fopen('contato.txt', 'a+');

		if ($fp) {
			foreach($contato as $id => $dados) {
				if(!empty($dados)) {
					fputs($fp, $id);
					fputs($fp, "\n");
					$linha=$dados['nome']."#".$dados['endereco']."#".$dados['telefone'];
					fputs($fp, $linha);
					fputs($fp, "\n");
				}
			}
			fclose($fp);
			echo "<script> alert('[OK] Contato Cadastrado com Sucesso!') </script>";
		}
	}

	function update($new, $id) {

		$contato = select();

		$fp = fopen('bkp.txt', 'a+');

		if ($fp) {
			foreach($contato as $chave => $dados) {
				if(!empty($dados)) {
					fputs($fp, $chave);
					if($id == trim($chave)){
						foreach($new as $new_id => $new_dados) {
							if(!empty($new_dados)) {
								$linha=$new_dados['nome']."#".$new_dados['endereco']."#".$new_dados['telefone']."\n";
							}
						}
					}
					else 
						$linha=$dados[0]."#".$dados[1]."#".$dados[2];
					fputs($fp, $linha);
				}
			}
			fclose($fp);
			echo "<script> alert('[OK] Curso Alterado com Sucesso!') </script>";

			unlink("contato.txt");
			rename("bkp.txt", "contato.txt");
		}
	}

	function remove($id) {
		$contato = select();

		$fp = fopen('bkp.txt', 'a+');

		if ($fp) {
			foreach($contato as $chave => $dados) {
				$linha=$dados[0]."#".$dados[1]."#".$dados[2];
				
				if(!empty($dados)) {
					if($id != trim($chave)) {
					 	fputs($fp, $chave);
						fputs($fp, $linha);
					}
				}
			}
			fclose($fp);

			echo "<script> alert('[OK] Pessoa Removida com Sucesso!') </script>";

			unlink("contato.txt");
			rename("bkp.txt", "contato.txt");
		} 
	}

?>

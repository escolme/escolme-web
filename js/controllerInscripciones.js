function InscripcionCtrl(uiService,sessionService,$scope,$http){

    //uiService.mostrarMenuSuperior(false);

    function Limpiar() {
        $scope.inscripcion = {
            id_usuario:0,login:'',sexo:'M',nombre:'',idDependencia:'',email:'',telefono:'',jefe:'',usuarioactivo:'S',
            passwordnew:'',id_perfil_grupo:0,id_empresa:sessionStorage.getItem("stIdEmpresa"),es_cad:false
        };
    }

}

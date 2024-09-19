import { Component, OnInit } from '@angular/core';
import { AbstractControl, FormControl, FormGroup, ReactiveFormsModule, ValidationErrors, Validators } from '@angular/forms';
import { ClientesService } from 'src/app/Services/clientes.service';
import { ICliente } from 'src/app/Interfaces/icliente';
import { CommonModule } from '@angular/common';
import Swal from 'sweetalert2';
import { ActivatedRoute, Router } from '@angular/router';

import { SharedModule } from 'src/app/theme/shared/shared.module';

@Component({
  selector: 'app-nuevocliente',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule],
  templateUrl: './nuevocliente.component.html',
  styleUrl: './nuevocliente.component.scss'
})
export class NuevoclienteComponent implements OnInit {
  frm_Cliente = new FormGroup({
    //idClients: new FormControl(),
    client_name: new FormControl('', Validators.required),
    client_surename: new FormControl('', Validators.required),
    client_phonenumber: new FormControl('', Validators.required),
    //Cedula: new FormControl('', [Validators.required, this.validadorCedulaEcuador]),
    client_email: new FormControl('', [Validators.required, Validators.email])
  });
  idClients = 0;
  titulo = 'Nuevo Cliente';
  constructor(
    private clienteServicio: ClientesService,
    private navegacion: Router,
    private ruta: ActivatedRoute
  ) {}

  ngOnInit(): void {
    this.idClients = parseInt(this.ruta.snapshot.paramMap.get('idClients'));
    if (this.idClients > 0) {
        this.clienteServicio.uno(this.idClients).subscribe((uncliente) => {
        this.frm_Cliente.controls['client_name'].setValue(uncliente.client_name);
        this.frm_Cliente.controls['client_surename'].setValue(uncliente.client_surename);
        this.frm_Cliente.controls['client_phonenumber'].setValue(uncliente.client_phonenumber);
        //this.frm_Cliente.controls['Cedula'].setValue(uncliente.Cedula);
        this.frm_Cliente.controls['client_email'].setValue(uncliente.client_email);
        /*this.frm_Cliente.setValue({
          client_name: uncliente.client_name,
          client_surename: uncliente.client_surename,
          client_phonenumber: uncliente.client_phonenumber,
          Cedula: uncliente.Cedula,
          client_email: uncliente.client_email
        });*/
        /*this.frm_Cliente.patchValue({
          Cedula: uncliente.Cedula,
          client_email: uncliente.client_email,
          client_name: uncliente.client_name,
          client_surename: uncliente.client_surename,
          client_phonenumber: uncliente.client_phonenumber
        });*/

        this.titulo = 'Editar Cliente' ;
      });
    }
     else
     {
       this.idClients =0;
     }
  }

  grabar() {
    let cliente: ICliente = {
      idClients: this.idClients,
      client_name: this.frm_Cliente.controls['client_name'].value,
      client_surename: this.frm_Cliente.controls['client_surename'].value,
      client_phonenumber: this.frm_Cliente.controls['client_phonenumber'].value,
      //Cedula: this.frm_Cliente.controls['Cedula'].value,
      client_email: this.frm_Cliente.controls['client_email'].value
      //console.log(this.frm_Cliente.controls['client_name'].value+this.frm_Cliente.controls['client_surename'].value)
    };

    Swal.fire({
      title: 'Clientes',
      text: 'Desea guardar al Cliente ' + this.frm_Cliente.controls['client_name'].value,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#f00',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Grabar!'
    }).then((result) => {
      if (result.isConfirmed) {
        if (this.idClients > 0) {
          this.clienteServicio.actualizar(cliente).subscribe((res: any) => {
            Swal.fire({
              title: 'Clientes',
              text: res.mensaje,
              icon: 'success'
            });
            this.navegacion.navigate(['/clientes']);
          });
        } else {
          this.clienteServicio.insertar(cliente).subscribe((res: any) => {
            Swal.fire({
              title: 'Clientes',
              text: res.mensaje,
              icon: 'success'
            });
            this.navegacion.navigate(['/clientes']);
          });
        }
      }
    });
  }

  validadorCedulaEcuador(control: AbstractControl): ValidationErrors | null {
    const cedula = control.value;
    if (!cedula) return null;
    if (cedula.length !== 10) return { cedulaInvalida: true };
    const provincia = parseInt(cedula.substring(0, 2), 10);
    if (provincia < 1 || provincia > 24) return { provincia: true };
    const tercerDigito = parseInt(cedula.substring(2, 3), 10);
    if (tercerDigito < 0 || tercerDigito > 5) return { cedulaInvalida: true };
    const digitoVerificador = parseInt(cedula.substring(9, 10), 10);
    const coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
    let suma = 0;
    for (let i = 0; i < coeficientes.length; i++) {
      const valor = parseInt(cedula.substring(i, i + 1), 10) * coeficientes[i];
      suma += valor > 9 ? valor - 9 : valor;
    }
    const resultado = suma % 10 === 0 ? 0 : 10 - (suma % 10);
    if (resultado !== digitoVerificador) return { cedulaInvalida: true };
    return null;
  }
}

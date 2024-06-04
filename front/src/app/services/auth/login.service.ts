import { Injectable } from '@angular/core';
import { LoginRequest } from './login.model';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, catchError, throwError, map } from 'rxjs';
import { User } from './user';

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  constructor(private http: HttpClient) { }



  login(credentials: LoginRequest): Observable<User> {
    // Realiza una solicitud HTTP GET para obtener un array de usuarios desde el archivo data.json
    return this.http.get<User[]>('././assets/data.json').pipe(
      // Utiliza el operador map para transformar el array de usuarios
      map(users => {
        // Busca un usuario en el array que tenga el mismo email y password que las credenciales proporcionadas
        const user = users.find(u => u.email === credentials.email && u.password === credentials.password);
        // Si encuentra un usuario que coincide, lo retorna
        if (user) {
          return user;
        } else {
          // Si no encuentra un usuario que coincide, lanza un error
          throw new Error('Invalid credentials');
        }
      }),
      // Maneja cualquier error que ocurra durante el proceso
      catchError(this.handleError)
    );
  }

  private handleError(error: HttpErrorResponse){
    console.log(error.status)
    if(error.status === 0){
      console.error('Se produjo un error: ', error.error);
    }else{
      console.error('El backend retornó el codigo de estado: ', error.status,error.error);
    }

    return throwError(()=> new Error('Algo falló, porfavor intente nuevamente'))
  }
}

import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { lastValueFrom  } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private ApiUrl = 'http://localhost:3000/api'

  constructor(private http: HttpClient) { }

  async login(email: string, password: string): Promise<any> {
    const observable = this.http.post(`${this.ApiUrl}/login`, {
      email,
      password
    });
    return await lastValueFrom(observable);
  }

  isAuthenticated(): boolean {
    const token = localStorage.getItem('jwt_token');
    // Simplemente verifica si hay un token
    return !!token;
    // Para una verificación más compleja, podrías decodificar el JWT y verificar su fecha de expiración, por ejemplo, usando una biblioteca como jwt-decode.
  }
}

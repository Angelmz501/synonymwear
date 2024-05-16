import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree, Router } from '@angular/router';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {

  constructor(private router: Router) {}

  canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean | UrlTree> | Promise<boolean | UrlTree> | boolean | UrlTree {

    const jwtToken = localStorage.getItem('jwt_token');
    if (jwtToken) {
      // Si el token existe, permitir el acceso a la ruta
      return true;
    } else {
      // Si no hay token, redirigir al usuario al login
      this.router.navigate(['/login']);
      return false;
    }
  }

}

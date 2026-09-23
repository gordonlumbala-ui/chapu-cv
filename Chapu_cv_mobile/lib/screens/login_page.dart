import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../services/auth_store.dart';
import '../services/cv_store.dart';
import '../theme/app_theme.dart';
import 'home_page.dart';
import 'register_page.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final _formKey = GlobalKey<FormState>();
  final _email = TextEditingController();
  final _password = TextEditingController();

  @override
  void dispose() {
    _email.dispose();
    _password.dispose();
    super.dispose();
  }

  Future<void> _submit() async {
    if (!_formKey.currentState!.validate()) return;

    final auth = context.read<AuthStore>();
    final ok = await auth.login(
      email: _email.text,
      password: _password.text,
    );

    if (!mounted) return;

    if (!ok) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(auth.error ?? 'Login failed')),
      );
      return;
    }

    await context.read<CvStore>().pullFromApi();
    if (!mounted) return;

    Navigator.of(context).pushAndRemoveUntil(
      MaterialPageRoute(builder: (_) => const HomePage()),
      (_) => false,
    );
  }

  @override
  Widget build(BuildContext context) {
    final busy = context.watch<AuthStore>().isBusy;

    return Scaffold(
      appBar: AppBar(title: const Text('Sign in')),
      body: Form(
        key: _formKey,
        child: ListView(
          padding: const EdgeInsets.fromLTRB(20, 16, 20, 28),
          children: [
            const Text(
              'Sign in to sync your CV with Chapu CV.',
              style: TextStyle(color: Colors.black54, height: 1.4),
            ),
            const SizedBox(height: 20),
            TextFormField(
              controller: _email,
              keyboardType: TextInputType.emailAddress,
              decoration: const InputDecoration(labelText: 'Email'),
              validator: (value) =>
                  (value == null || value.trim().isEmpty) ? 'Email is required' : null,
            ),
            const SizedBox(height: 12),
            TextFormField(
              controller: _password,
              obscureText: true,
              decoration: const InputDecoration(labelText: 'Password'),
              validator: (value) =>
                  (value == null || value.isEmpty) ? 'Password is required' : null,
            ),
            const SizedBox(height: 20),
            FilledButton(
              onPressed: busy ? null : _submit,
              child: busy
                  ? const SizedBox(
                      height: 20,
                      width: 20,
                      child: CircularProgressIndicator(strokeWidth: 2, color: Colors.white),
                    )
                  : const Text('Sign in'),
            ),
            const SizedBox(height: 12),
            TextButton(
              onPressed: busy
                  ? null
                  : () {
                      Navigator.of(context).push(
                        MaterialPageRoute(builder: (_) => const RegisterPage()),
                      );
                    },
              child: const Text(
                'Create an account',
                style: TextStyle(color: AppTheme.brandGreen),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

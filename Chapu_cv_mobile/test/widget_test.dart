import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:provider/provider.dart';
import 'package:shared_preferences/shared_preferences.dart';

import 'package:chapu_cv_mobile/main.dart';
import 'package:chapu_cv_mobile/screens/landing_page.dart';
import 'package:chapu_cv_mobile/services/api_client.dart';
import 'package:chapu_cv_mobile/services/cv_store.dart';

void main() {
  TestWidgetsFlutterBinding.ensureInitialized();

  setUp(() {
    SharedPreferences.setMockInitialValues({});
  });

  testWidgets('Landing page shows Chapu CV and MALAFYALE TECH', (tester) async {
    final store = CvStore(ApiClient());
    await store.load();

    await tester.pumpWidget(
      ChangeNotifierProvider.value(
        value: store,
        child: const MaterialApp(home: LandingPage()),
      ),
    );

    expect(find.text('Chapu CV'), findsWidgets);
    expect(find.textContaining('MALAFYALE TECH'), findsWidgets);
    expect(find.text('Get Started'), findsOneWidget);
    expect(find.text('+255782028232'), findsOneWidget);
    expect(find.text('stuartsmg7@gmail.com'), findsOneWidget);
  });

  testWidgets('App boots to landing when not started', (tester) async {
    await tester.pumpWidget(const ChapuCvApp());
    await tester.pumpAndSettle();

    expect(find.text('Get Started'), findsOneWidget);
  });
}

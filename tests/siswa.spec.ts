import { test, expect } from '@playwright/test';

const BASE = '/cloud-simulasimandiri';
const TEST_STUDENT = {
  nis: '88881',
  user: 'PWSTUDENT01',
  nama: 'PW Student Initial',
  namaEdited: 'PW Student Edited',
  pass: '123456',
  nik: 'NIK88881',
  nik2: 'SMP PLAYWRIGHT',
  server: 'SERVER-A',
  sesi: '1',
};

async function ensureLoggedIn(page) {
  await page.goto(`${BASE}/wp-login.php`);
  if (page.url().includes('wp-admin')) {
    return;
  }
  await page.waitForSelector('#user_login');
  await page.fill('#user_login', 'yokowasis');
  await page.fill('#user_pass', 'nihlah2010');
  await page.click('#wp-submit');
  await page.waitForURL(/wp-admin/);
}

test.describe.serial('Student Management Tests', () => {
  test.setTimeout(120000);

  test('1. add student (from menu tambah siswa)', async ({ page }) => {
    await ensureLoggedIn(page);

    // Verify Data Siswa top-level menu exists in sidebar
    const siswaMenu = page.locator('#adminmenu li.menu-top', { hasText: 'Data Siswa' });
    await expect(siswaMenu).toBeVisible();

    await page.goto(`${BASE}/wp-admin/admin.php?page=bimasoft_database_tambah_siswa_slug`);
    await expect(page.locator('h2')).toContainText('Tambah Siswa');

    // Verify Download sample.xlsx button is present
    const downloadBtn = page.locator('#downloadSampleBtn');
    await expect(downloadBtn).toBeVisible();
    await expect(downloadBtn).toHaveAttribute('href', /sample\.xlsx$/);

    // Verify Key row is removed from visible UI
    const keyRow = page.locator('tr:has-text("Key:")');
    await expect(keyRow).toHaveCount(0);

    // Select Mapel
    await page.selectOption('#mapelSelect', 'TEST');

    // Fill student data (tab-delimited format)
    const tabData = `${TEST_STUDENT.nis}\t${TEST_STUDENT.user}\t${TEST_STUDENT.nama}\t${TEST_STUDENT.pass}\t${TEST_STUDENT.nik}\t${TEST_STUDENT.nik2}\t${TEST_STUDENT.server}\t${TEST_STUDENT.sesi}`;
    await page.fill('#siswaData', tabData);

    // Submit form
    await page.click('#uploadBtn');

    // Assert upload success message
    const resultDiv = page.locator('#uploadResult');
    await expect(resultDiv).toBeVisible();
    await expect(resultDiv).toContainText('Data Siswa Berhasil di Simpan');
  });

  test('2. edit student (from data siswa)', async ({ page }) => {
    await ensureLoggedIn(page);

    // Navigate to Data Siswa
    await page.goto(`${BASE}/wp-admin/admin.php?page=bimasoft_database_reset_siswa_slug`);
    await page.waitForSelector('table.dataTables');

    // Locate student row
    const row = page.locator('table.dataTables tbody tr', { hasText: TEST_STUDENT.user });
    await expect(row).toBeVisible();

    // Click Edit
    await row.locator('.rowedit').click();

    // Edit student name (cell index 4)
    const nameInput = row.locator('td').nth(4).locator('input');
    await expect(nameInput).toBeVisible();
    await nameInput.fill(TEST_STUDENT.namaEdited);

    // Click Save
    await row.locator('.rowsave').click();

    // Wait and assert name is updated
    await page.waitForTimeout(1500);
    const updatedName = row.locator('td').nth(4);
    await expect(updatedName).toContainText(TEST_STUDENT.namaEdited);
  });

  test('3. delete student (from data siswa)', async ({ page }) => {
    await ensureLoggedIn(page);

    // Navigate to Data Siswa
    await page.goto(`${BASE}/wp-admin/admin.php?page=bimasoft_database_reset_siswa_slug`);
    await page.waitForSelector('table.dataTables');

    // Locate student row
    const row = page.locator('table.dataTables tbody tr', { hasText: TEST_STUDENT.user });
    await expect(row).toBeVisible();

    // Click Del
    await row.locator('.rowdelete').click();
    await page.waitForTimeout(1500);

    // Reload page to verify student is permanently deleted
    await page.reload();
    await page.waitForSelector('table.dataTables');
    const remainingRows = page.locator('table.dataTables tbody tr', { hasText: TEST_STUDENT.user });
    await expect(remainingRows).toHaveCount(0);
  });
});
